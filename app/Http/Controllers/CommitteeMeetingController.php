<?php

namespace App\Http\Controllers;

use App\User;
use Carbon\Carbon;
use App\Notification;
use App\CommitteeAgenda;
use App\CommitteeMeeting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommitteeMeetingController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('restrict:admin', ['only' => ['index', 'create', 'update', 'store', 'update', 'destroy', 'action', 'addUsers']]);
    }

    public function index()
    {

        $meetings = CommitteeMeeting::with('committee')->where('status', 'scheduled')->get();

        return view('committee.index', compact('meetings'));
    }

    public function create()
    {
        return null;
    }

    public function store(Request $request)
    {
        $request->validate([
            'agendas' => 'required',
            'committee_id' => 'required|numeric'
        ]);

        $meeting = CommitteeMeeting::where('status', 'scheduled')->where('committee_id', $request->committee_id)->first();

        $agendas = CommitteeAgenda::find($request->agendas);
        $meeting->agendas()->attach($request->agendas);
        // $meeting->agendas()->syncWithoutDetaching($request->agendas);
        foreach ($agendas as $agenda) {
            $agenda->status = 'takenup';
            $agenda->save();
        }

        return redirect("/committee/meeting/$meeting->id")->with('status', 'agendas added');
    }

    public function show($id)
    {
        $meeting = CommitteeMeeting::with('committee')->find($id);
        $agendas = $meeting->agendas->where('status', 'takenup')->sortBy('uid');

        if ($meeting->status == 'over') {
            return 'archived';
        }

        $tab = 1;
        return view('committee.meeting.show', compact('meeting', 'agendas', 'tab'));
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

        $meeting = CommitteeMeeting::findOrFail($id);
        $meeting->name = $request->name;
        $meeting->date = $request->date;
        $meeting->time = $request->time;
        $meeting->place = $request->place;
        $meeting->save();

        // Notification::create([
        //     'title' => "$meeting->name " . $meeting->committee->name . " Meeting is scheduled to be held on $meeting->date at $meeting->time"
        // ]);

        return redirect()->back()->with('success', 'Meeting details updated successfully');
    }

    public function destroy($id)
    {
        $meeting = CommitteeMeeting::find($id);

        if (!$meeting->date) {
            return redirect()->back()->with('error', "Operation not allowed!");
        }

        $meeting->status = 'over';
        $meeting->save();

        $new = CommitteeMeeting::create([
            'name' => $meeting->name + 1,
            'date' => '2019-01-01',
            'committee_id' => $meeting->committee_id,
            'time' => '10:00'
        ]);

        $users = User::where('role', '!=', 'invitee')->pluck('id');
        $new->users()->sync($users);

        return redirect("/committee/meeting/$new->id")->with('success', 'Meeting ended successfully');
    }

    public function action(Request $request, $action)
    {

        $request->validate([
            'agendas' => 'required',
            'committee_id' => 'required'
        ]);

        $meeting = CommitteeMeeting::where('committee_id', $request->committee_id)->where('status', 'scheduled')->first();

        switch ($action) {
            case 'circulate':
                $agendas = CommitteeAgenda::find($request->agendas);
                foreach ($agendas as $agenda) {
                    $agenda->visibility = true;
                    $agenda->added_at = Carbon::now()->toDateString();
                    $agenda->save();
                }
                return redirect("/notification/create?meeting=committee&id=$meeting->id");
                break;
            case 'archive':
                $agendas = CommitteeAgenda::find($request->agendas);
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
                $agendas = CommitteeAgenda::find($request->agendas);
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

    public function indexSheet($id)
    {

        $meeting = CommitteeMeeting::where('status', 'scheduled')->where('committee_id', $id)->first();

        if (Auth::user()->role === 'invitee') {
            $agendas = Auth::user()->committeeAgendas->where('status', 'takenup');
        } else {

            if (in_array(Auth::user()->username, $meeting->users->pluck('username')->toArray())) {
                $agendas = $meeting->agendas->where('visibility', true);
            } else {
                return redirect('/board/meeting')->with('error', 'Sorry, you don\'t have access to this meeting. Please contact admin.');
            }
        }

        $leave = $agendas->where('category', 'Leave of Absence')->sortBy('uid');
        $minutes = $agendas->where('category', 'Minutes')->sortBy('uid');
        $approval = $agendas->where('type', 'Approval')->sortBy('uid');
        $information = $agendas->where('type', 'Information')->sortBy('uid');
        if (config('app.company') == 'ovl')
            $grantingOrNoting = $agendas->where('type', 'Granting')->where('category', '!=', 'Leave of Absence')->sortBy('uid');
        else
            $grantingOrNoting = $agendas->where('type', 'Noting')->where('category', '!=', 'Leave of Absence')->where('category', '!=', 'Minutes')->sortBy('uid');
        $category = 'All';
        $dates = $agendas->unique('added_at')->pluck('added_at');
        $selectedDate = '';

        return view('committee.meeting.index', compact('meeting', 'leave', 'minutes', 'approval', 'information', 'grantingOrNoting', 'category', 'dates', 'selectedDate'));
    }

    public function users($id)
    {

        $meeting = CommitteeMeeting::findOrFail($id);
        $agendas = $meeting->agendas;
        $tab = 2;

        return view('committee.meeting.show', compact('tab', 'meeting', 'agendas'));
    }

    public function addUsers(Request $request, $id)
    {

        $meeting = CommitteeMeeting::findOrFail($id);
        $meeting->users()->sync($request->users);

        return redirect()->back()->with('success', 'Users added to meeting!');
    }

    public function filter(Request $request, $id)
    {

        $meeting = CommitteeMeeting::findOrFail($id);

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
        $minutes = $agendas->where('category', 'Minutes')->sortBy('uid');
        $approval = $agendas->where('type', 'Approval')->sortBy('uid');
        $information = $agendas->where('type', 'Information')->sortBy('uid');
        if (config('app.company') == 'ovl')
            $grantingOrNoting = $agendas->where('type', 'Granting')->where('category', '!=', 'Leave of Absence')->sortBy('uid');
        else
            $grantingOrNoting = $agendas->where('type', 'Noting')->where('category', '!=', 'Leave of Absence')->sortBy('uid');

        $dates = $meeting->agendas->unique('added_at')->pluck('added_at');

        return view('committee.meeting.index', compact('meeting', 'leave', 'minutes', 'approval', 'information', 'grantingOrNoting', 'category', 'dates', 'selectedDate'));
    }
}
