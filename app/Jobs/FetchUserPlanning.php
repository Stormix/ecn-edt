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
        $max = 100;
        $this->setProgressMax($max);
        // Call API
        $baseUrl = env('API_URL');
        $endPoint = "/api/extract";
        $headers = [
            "Content-Type"  => "application/json"
        ];
        $requestBody = [
            "name" => "anas",
            "username" => "amazouni2018",
            "password" => "AnasStormix1234"
        ];

        $client = new Client(['base_uri' => $baseUrl]);
        $response = $client->post($endPoint, array('json'=> $requestBody));
        $this->setProgressNow(50);
        $filename = $this->user->id."/".strtolower(date('F'))."/planning.ics";
        Storage::put("public/".$filename , $response->getBody()->getContents());
        $this->setProgressNow(80);
        $this->user->account()->update(['status' => 2]);
        $this->user->calendar()->updateOrCreate(['user_id' => $this->user->id], ['name' => "Calendar Name #".$max, 'url' => env('APP_URL')."/storage/".$filename]);
        $this->setProgressNow(100);
        $this->setOutput(['total' => $max, 'calendar' => $this->user->calendar]);
    }
    // /**
    //  * The job failed to process.
    //  *
    //  * @param  Exception  $exception
    //  * @return void
    //  */
    // public function failed(Exception $exception)
    // {
    //     // Send user notification of failure, etc...
    // }
}
