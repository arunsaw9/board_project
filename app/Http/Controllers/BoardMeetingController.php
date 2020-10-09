<?php

namespace App\Http\Controllers;

use App\User;
use Carbon\Carbon;
use App\BoardAgenda;
use App\BoardMeeting;
use App\Jobs\MailJob;
use App\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BoardMeetingController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth'); 
        $this->middleware('restrict:admin,user', ['except' => ['index']]);
    }

    public function index()
    {
        $meeting = BoardMeeting::where('status', 'scheduled')->first();

        if (Auth::user()->role === 'invitee') {
            $agendas = Auth::user()->boardAgendas->where('status', 'takenup');
        } else {

            if (in_array(Auth::user()->username, $meeting->users->pluck('username')->toArray())) {
                $agendas = $meeting->agendas->where('visibility', true);
            } else {
                return redirect()->back()->with('error', 'Sorry, you don\'t have access to this meeting. Please contact admin.');
            }
        }

//echo "<pre>";print_r($agendas->toArray());die;
        //return $agendas;

        $leave = $agendas->where('category', 'Leave of Absence');
        $minutes = $agendas->where('category', 'Minutes')->sortBy('priority');
        $approval = $agendas->where('type', 'Approval')->sortBy('priority');
         $information = $agendas->where('type', 'Review | Information')->sortBy('priority');
        if (config('app.company') == 'ovl')
            $grantingOrNoting = $agendas->where('type', 'Granting')->where('category', '!=', 'Leave of Absence')->sortBy('priorityv');
        else
            $grantingOrNoting = $agendas->where('type', 'Noting')->where('category', '!=', 'Leave of Absence')->sortBy('priority');
        $category = 'All';
        $dates = $agendas->unique('added_at')->pluck('added_at');
        $selectedDate = '';

        return view('board.meeting.index', compact('meeting', 'leave', 'minutes', 'approval', 'information', 'grantingOrNoting', 'category', 'dates', 'selectedDate'));
    }

    public function create()
    {
        return null;
    }

    public function store(Request $request)
    {
        $request->validate([
            'agendas' => 'required',
        ]);

        $meeting = BoardMeeting::where('status', 'scheduled')->first();
        $agendas = BoardAgenda::find($request->agendas);

        // NEW LOGIC
        $meeting->agendas()->attach($request->agendas);
        foreach ($agendas as $agenda) {
            $agenda->status = 'takenup';
            $agenda->save();
        }

        return redirect("/board/meeting/admin")->with('success', 'Agendas added to meeting!');
    }

    public function show($id)
    {
        $meeting = BoardMeeting::findOrFail($id);
        return view('board.meeting.show', compact('meeting'));
    }

    public function edit($id)
    {
        return $id;
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'numeric'
        ]);

        $meeting = BoardMeeting::findOrFail($id);
        $meeting->name = $request->name;
        $meeting->date = $request->date;
        $meeting->time = $request->time;
        $meeting->place = $request->place;
        $meeting->save();

        // Notification::create([
        //     'title' => "$meeting->name Board Meeting is scheduled to be held on $meeting->date at $meeting->time"
        // ]);

        return redirect()->back()->with('success', 'Meeting details updated successfully');
    }

    public function destroy($id)
    {
        $meeting = BoardMeeting::findOrFail($id);

        if (!$meeting->date) {
            return redirect()->back()->with('error', "Operation not allowed!");
        }

        $meeting->status = 'over';
        $meeting->save();

        $new = BoardMeeting::create([
            'name' => $meeting->name + 1,
            'date' => '2019-01-01',
            'time' => '10:00'
        ]);

        $users = User::where('role', '!=', 'invitee')->pluck('id');
        $new->users()->sync($users);

        return redirect()->back()->with('success', 'Meeting ended successfully');
    }

    public function admin($tab = 1)
    {

        $meeting = BoardMeeting::where('status', 'scheduled')->first();
        $agendas = $meeting->agendas->where('status', 'takenup');

        return view('board.meeting.admin', compact('tab', 'meeting', 'agendas'));
    }

    public function action(Request $request, $action)
    {

        $request->validate([
            'agendas' => 'required'
        ]);

        $meeting = BoardMeeting::where('status', 'scheduled')->first();

        switch ($action) {
            case 'circulate':
                $agendas = BoardAgenda::find($request->agendas);
                foreach ($agendas as $agenda) {
                    $agenda->visibility = true;
                    $agenda->added_at = Carbon::now()->toDateString();
                    $agenda->save();
                }
                $meeting->type = 'Board Meeting';
                return redirect("/notification/create?meeting=board&id=$meeting->id");
                // MailJob::dispatch(Auth::user(), $meeting);
                break;
            case 'archive':
                $agendas = BoardAgenda::find($request->agendas);
                foreach ($agendas as $agenda) {
                    $agenda->status = 'archive';
                    $agenda->save();
                }
                $pivots = $meeting->agendas;
                foreach ($pivots as $pivot) {
                    $pivot->pivot->status = 'archive';
                    $pivot->pivot->save();
                }
                break;
            case 'defer':
                $agendas = BoardAgenda::find($request->agendas);
                foreach ($agendas as $agenda) {
                    $agenda->status = 'defer';
                    $agenda->save();
                }
                $pivots = $meeting->agendas;
                foreach ($pivots as $pivot) {
                    $pivot->pivot->status = 'defer';
                    $pivot->pivot->save();
                }
                break;
            default:
                abort(404);
                break;
        }

        return redirect()->back()->with('success', "Selected agenda succesfully " . $action . "d");
    }

    public function archive()
    {
        $meetings = BoardMeeting::paginate(10);
        return view('board.meeting.archive', compact('meetings'));
    }

    public function users(Request $request)
    {

        $meeting = BoardMeeting::where('status', 'scheduled')->first();
        $meeting->users()->sync($request->users);

        return redirect()->back()->with('success', 'Users added to meeting!');
    }

    public function filter(Request $request)
    {

        $meeting = BoardMeeting::where('status', 'scheduled')->first();

        if ($request->category) {
            $category = $request->category;
            $selectedDate = '';

            if ($category === 'All') {
                return redirect('/board/meeting');
            }

            if (Auth::user()->role === 'invitee') {
                $agendas = Auth::user()->boardAgendas->where('status', 'takenup');
            } else {
                $agendas = $meeting->agendas->where('visibility', true)->where('category', $category);
            }
        } else {

            $selectedDate = $request->date;
            $category = 'All';

            if ($selectedDate == "") {
                return redirect('/board/meeting');
            }

            if (Auth::user()->role === 'invitee') {
                $agendas = Auth::user()->boardAgendas->where('status', 'takenup');
            } else {
                $agendas = $meeting->agendas->where('visibility', true)->where('added_at', $selectedDate);
            }
        }

        $leave = $agendas->where('category', 'Leave of Absence');
        $minutes = $agendas->where('category', 'Minutes')->sortBy('priority');
        $approval = $agendas->where('type', 'Approval')->sortBy('priority');
        $information = $agendas->where('type', 'Information')->sortBy('priority');
        if (config('app.company') == 'ovl')
            $grantingOrNoting = $agendas->where('type', 'Granting')->where('category', '!=', 'Leave of Absence')->sortBy('priority');
        else
            $grantingOrNoting = $agendas->where('type', 'Noting')->where('category', '!=', 'Leave of Absence')->sortBy('priority');

        $dates = $meeting->agendas->unique('added_at')->pluck('added_at');

        return view('board.meeting.index', compact('meeting', 'leave', 'minutes', 'approval', 'information', 'grantingOrNoting', 'category', 'dates', 'selectedDate'));
    }
}
