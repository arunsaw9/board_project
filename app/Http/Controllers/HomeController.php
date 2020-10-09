<?php

namespace App\Http\Controllers;

use App\User;
use App\Category;
use App\Committee;
use Carbon\Carbon;
use App\BoardAgenda;
use App\BoardMeeting;
use App\Jobs\MailJob;
use App\Notification;
use App\CommitteeAgenda;
use App\CommitteeMeeting;
use Illuminate\Http\Request;
use App\Mail\MailNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('restrict:admin', [ 'only' => ['logs'] ]);
    }

    public function index()
    {

        $meeting = BoardMeeting::where('status', 'scheduled')->first();

        $notifications = Notification::all()->sortByDesc('id');

        $options = [
            ["title" => "Committee Meeting", "description" => "Scheduled to be held on Wednesday 25th of September 2019 10:00 AM", "style" => "background: linear-gradient(135deg, #5b247a 0%,#1bcedf 100%);"],
            // [ "title" => "AGM", "description" => "Scheduled to be held on xx.xx.xx", "style" => "background:linear-gradient(135deg, #65799b 0%,#5e2563 100%);"  ],
            // [ "title" => "EGM", "description" => "Scheduled to be held on xx.xx.xx", "style" => "background:linear-gradient(135deg, #0FF0B3 0%,#036ED9 100%);"  ],
        ];

        return view('home', compact('options', 'meeting', 'notifications'));
    }

    public function board($tab = 1)
    {

        switch ($tab) {
            case 1:
                $agendas = BoardAgenda::with('committee')->where('status', 'created')->orWhere('status', 'defer')->get();
                break;
            case 2:
                $agendas = BoardAgenda::with('committee')->where('committee_id', '>', 0)->where('copied_to_committee', false)->get();
                break;
            case 3:
                $agendas = BoardAgenda::with('committee')->paginate(10);
                break;
            default:
                abort(404);
                break;
        }

        return view('board.home', compact('agendas', 'tab'));
    }

    public function committee($id)
    {

        // $agendas = CommitteeAgenda::where('status', 'created')->orWhere('status', 'defer')->where('committee_id', $id)->get();
        $committee = Committee::find($id);
        $agendas = CommitteeAgenda::where('committee_id', $id);
        $agendas = $agendas->where('status', 'created')->orWhere('status', 'defer')->get();

        $meeting = CommitteeMeeting::where('status', 'scheduled')->where('committee_id', $id)->first();

        if ($meeting)
            return view('committee.home', compact('agendas', 'committee', 'meeting'));
        else
            abort(500);
    }

    public function logs(Request $request)
    {
        $model = $request->input('model');

        switch ($model) {
            case 'boardmeeting':
                $logs = BoardMeeting::with('audits')->get();
                return view('audits.index', compact('logs'));
                break;
            case 'boardagenda':
                $logs = BoardAgenda::with('audits')->get();
                return view('audits.index', compact('logs'));
                break;
            case 'committeemeeting':
                $logs = CommitteeMeeting::with('audits')->get();
                return view('audits.index', compact('logs'));
                break;
            case 'committeeagenda':
                $logs = CommitteeAgenda::with('audits')->get();
                return view('audits.index', compact('logs'));
                break;
            case 'user':
                $logs = User::with('audits')->get();
                return view('audits.index', compact('logs'));
                break;
            case 'notification':
                $logs = Notification::with('audits')->get();
                return view('audits.index', compact('logs'));
                break;
            default:
                $logs = '[]';
                return view('audits.index', compact('logs'));
                break;
        }
    }

    public function token()
    {
        return Auth::user()->api_token;
    }

    public function test() {
        MailJob::dispatch(User::find(1), 'hello');

        return ['status' =>'success'];
    }
}
