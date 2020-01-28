<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\User;
use Imtigger\LaravelJobStatus\Trackable;

class FetchUserPlanning implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, Trackable;
    protected $account;
    protected $user;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->account = $user->account;
        $this->user = $user;
        $this->prepareStatus();
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $max = mt_rand(5, 30);
        $this->setProgressMax($max);

        for ($i = 0; $i <= $max; $i += 1) {
            sleep(1); // Some Long Operations
            $this->setProgressNow($i);
        }
        $this->user->account()->update(['status' => 2]);
        $this->user->calendar()->updateOrCreate(['user_id' => $this->user->id], ['name' => "Calendar Name #".$max, 'url' => "http://localhost/"]);
        $this->setOutput(['total' => $max, 'calendar' => $this->user->calendar]);
    }
    /**
     * The job failed to process.
     *
     * @param  Exception  $exception
     * @return void
     */
    public function failed(Exception $exception)
    {
        // Send user notification of failure, etc...
    }
}
