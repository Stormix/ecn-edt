<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use RedisManager;
use App\Jobs\FetchUserPlanning;
use App\Jobs\SynchronizeGoogleCalendar;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Imtigger\LaravelJobStatus\JobStatus;
use Queue;
use Webpatser\Uuid\Uuid;
use Illuminate\Support\Facades\Crypt;

class ExtractorController extends Controller
{
    use DispatchesJobs;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Save onBoard login.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'username' => 'required',
            'password' => 'required',
        ]);
        $password = Crypt::encryptString($request->input('password'));
        $user = Auth::user();
        $user->account()->updateOrCreate(['user_id' => $user->id], ['name' => $request->input('name'), 'username' => $request->input('username'), 'password' => $password]);
        return redirect()->route('home')
            ->with('success', 'OnBoard logins saved!');
    }
    /**
     * Publish job.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function add()
    {

        $user = Auth::user();
        if ($user->account) {
            $user->account->status = 1;
            $user->account->save();
            $key = (String) Uuid::generate(4);
            FetchUserPlanning::withChain([
                new SynchronizeGoogleCalendar($user),
            ])->dispatch($user, $key);
            $jobStatus = JobStatus::where('key', $key)->first();
            $queueSize = Queue::size();
            // RedisManager::publish('extract', json_encode(['username' => $user->account->username, 'password' => $user->account->password]));
            return redirect()->route('home')
                    ->cookie(
                        'extraction_job', $jobStatus->id, 24*60
                    )
                    ->with('info', 'New extraction job #'.$queueSize.' is queued! Keep this page open to get progress updates.');
        }else{

        return redirect()->route('home')
            ->with('error', 'Please add your OnBoard logins first!');
        }
    }

    /**
     * Publish job.
     *
     * @return
     */
    public function status($id){
        $status = JobStatus::findOrFail($id);
        return response()->json($status, 200);
    }

    public function calendar(){
        $user = Auth::user();
        return response()->json($user->calendar, 200);
    }

}
