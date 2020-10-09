<?php

namespace App\Http\Controllers;

use App\User;
use App\BoardMeeting;
use App\Jobs\MailJob;
use App\Notification;
use GuzzleHttp\Client;
use App\CommitteeMeeting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class NotificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('restrict:admin', ['only' => ['store', 'destroy']]);
    }

    public function index()
    {
        $notifications = Notification::all();
        return view('notification.index', compact('notifications'));
    }

    public function create(Request $request)
    {
        if ($request->has('meeting') && $request->has('id')) {
            switch ($request->input('meeting')) {
                case 'board':
                    $meeting = BoardMeeting::find($request->input('id'))->first();
                    $message = "$meeting->name Board Meeting is scheduled to be held on $meeting->date, $meeting->time";
                    break;
                case 'committee':
                    $meeting = CommitteeMeeting::find($request->input('id'))->first();
                    $message = "$meeting->name " . $meeting->committee->name . " Meeting is scheduled to be held on $meeting->date, $meeting->time";
                    break;
                default:
                    abort(404);
            }

            return view('notification.create', compact('message'));
        }

        return view('notification.custom');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'users' => 'required'
        ]);

        $this->sendSms($request->users, substr($request->title, 0, 160));
        if (strlen($request->title) > 160) {
            $this->sendSms($request->users, substr($request->title, 160, 320));
        }
        // $this->sendSms($request->users, substr($request->title, 320, 480));

        if (config('app.env') == 'production') {
            MailJob::dispatch(User::find($request->users), $request->title);
        }

        if ($request->save) {
            Notification::create([
                'title' => $request->title
            ]);
        }

        return redirect()->back()->with('success', 'Notification created');
    }

    public function sendSms($users, $body)
    {

        $msg = urlencode($body);
        $mobiles = join("+", User::find($users)->pluck('mobile')->toArray());
        $url = "http://10.205.48.190:13013/cgi-bin/sendsms?username=ongc&password=ongc12&from=ONGC&to=$mobiles&text=$msg&charset=UTF-8";

        $client = new Client();
        $client->request('GET', $url);
    }

    public function show(Notification $notification)
    {
        return $notification;
    }

    public function edit(Notification $notification)
    {
        //
    }

    public function update(Request $request, Notification $notification)
    {
        //
    }

    public function destroy(Notification $notification)
    {
        $notification->delete();

        return redirect()->back()->with('success', 'Notification Deleted');
    }
}
