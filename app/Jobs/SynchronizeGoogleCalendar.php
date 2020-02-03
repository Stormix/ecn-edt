<?php

namespace App\Jobs;

use App\Services\Google;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use ICal\ICal;
use Google_Service_Calendar_Calendar;
use Google_Service_Calendar_Event;

class SynchronizeGoogleCalendar implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $calendar_id;
    protected $calendar;
    protected $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function getGoogleService()
    {
        return app(Google::class)
            ->connectUsing($this->user->token)
            ->service('Calendar');
    }

    public function getGoogleCalendars($service, $options)
    {
        return $service->calendarList->listCalendarList($options);
    }

    public function getCalendarEvents($service, $options)
    {
        return $service->events->listEvents(
            $this->calendar_id,
            $options
        );
    }

    public function setCalendarId()
    {
        // Start with an empty page token.
        $pageToken = null;
        $summary = config('app.calendar_name', "EDT ECN - OnBoardPlanning");

        // Delegate service instantiation to the sub class.
        $service = $this->getGoogleService();

        $id = null;

        do {
            $list = $this->getGoogleCalendars($service, compact('pageToken'));
            foreach ($list->getItems() as $item) {
                // Find the correct calendar
                if ($item->summary == $summary) {
                    $id = $item->id;
                }
            }

            // Get the new page token from the response.
            $pageToken = $list->getNextPageToken();

            // Continue until the new page token is null.
        } while ($pageToken);

        if (!$id) {
            // Create calendar !
            $calendar = new Google_Service_Calendar_Calendar();
            $calendar->setSummary($summary);
            $calendar->setTimeZone('Europe/Paris');
            $createdCalendar = $service->calendars->insert($calendar);
            $id = $createdCalendar->getId();
        }
        $this->calendar_id = $id;
        $this->user->account()->update(['status' => 4]);
        $this->user->calendar()->updateOrCreate(['user_id' => $this->user->id], ['name' => 'Fetching calendar ...', 'live_url' => null]);

        return $id != null;
    }

    public function syncEvents()
    {

        // First delete all events

        // Start with an empty page token.
        $pageToken = null;

        // Delegate service instantiation to the sub class.
        $service = $this->getGoogleService();


        do {
            // Ask the sub class to perform an API call with this pageToken (initially null).
            $list = $this->getCalendarEvents($service, compact('pageToken'));

            foreach ($list->getItems() as $event) {
                //  Delete all events
                $this->deleteEvent($service, $event);
            }

            // Get the new page token from the response.
            $pageToken = $list->getNextPageToken();

            // Continue until the new page token is null.
        } while ($pageToken);

        // Insert new events
        $calendar = $this->getICSCalendar();
        $newEvents = $this->getEventsFromICS($calendar);
        foreach ($newEvents as $event) {
            $this->insertEvent($service, $event);
        }
    }

    public function handle()
    {
        if ($this->setCalendarId()) {
            $this->syncEvents();
            $this->user->account()->update(['status' => 5]);
            $this->user->calendar()->updateOrCreate(['user_id' => $this->user->id], ['name' => config('app.calendar_name', "EDT ECN - OnBoardPlanning"), 'live_url' => "https://calendar.google.com/calendar/embed?src=" . $this->calendar_id]);
        }
    }


    public function deleteEvent($service, $event)
    {
        $service->events->delete($this->calendar_id, $event->id);
    }
    public function getICSCalendar()
    {
        try {
            $calendarURL = $this->user->calendar->url;
            $calendarPath = explode('storage/', $calendarURL)[1];
            $ICSpath = \Storage::disk('public')->path($calendarPath);
            $ical = new ICal($ICSpath, array(
                'defaultTimeZone' => 'Europe/Paris',
            ));
            $this->calendar = $ical;
        } catch (\Exception $e) {
            die($e);
        }
    }
    public function getEventsFromICS()
    {
        $ics = $this->calendar;
        return $ics->events();
    }
    public function insertEvent($service, $event)
    {
        $summary = explode('\n', $event->summary);
        $groups = explode('/', $summary[1]);
        $desc = "Groupes: " . trim($groups[1]);
        $profs = $groups[2];
        $newEvent = new Google_Service_Calendar_Event(array(
            'summary' => trim($summary[0]) . " - " . trim($profs),
            'location' => str_replace(array("\r", "\n"), '', $event->location),
            'description' => trim($desc),
            'start' => array(
                'dateTime' => \Carbon\Carbon::parse($event->dtstart_tz)->toRfc3339String()
            ),
            'end' => array(
                'dateTime' => \Carbon\Carbon::parse($event->dtend_tz)->toRfc3339String()
            ),
        ));

        $service->events->insert($this->calendar_id, $newEvent);
    }
}
