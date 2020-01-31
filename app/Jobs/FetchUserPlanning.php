<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\User;
use Imtigger\LaravelJobStatus\Trackable;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Storage;

$baseUrl = env('API_URL');

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
    public function __construct(User $user, $key)
    {
        $this->account = $user->account;
        $this->user = $user;
        $this->prepareStatus(['key' => $key]);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $max = 100;
        $this->setProgressMax($max);
        // Call API
        $baseUrl = env('API_URL');
        $endPoint = "/api/extract";
        $headers = [
            "Content-Type"  => "application/json"
        ];
        $requestBody = [
            "name" => $this->account->name,
            "username" => $this->account->username,
            "password" => $this->account->password
        ];
        try {
            $client = new Client(['base_uri' => $baseUrl]);
            $response = $client->post($endPoint, array('json' => $requestBody));
            $responseBody = $response->getBody()->getContents();

            $this->setProgressNow(50);
            $filename = $this->user->id . "/" . strtolower(date('F')) . "/planning.ics";
            Storage::put("public/" . $filename, $responseBody);
            $this->setProgressNow(80);
            $this->user->account()->update(['status' => 2]);
            $calendar = $this->user->calendar()->updateOrCreate(['user_id' => $this->user->id], ['name' => "Wating for Sync Job", 'url' => env('APP_URL') . "/storage/" . $filename]);
            $this->setProgressNow(100);
            $this->setOutput(['total' => $max, 'calendar' => $calendar]);
        } catch (\Throwable $th) {
            $this->user->account()->update(['status' => 3]);
            throw $th;
        }
    }
}
