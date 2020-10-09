<?php

namespace App\Http\Controllers;

use App\CommitteeMeeting;
use Illuminate\Http\Request;

class ArchiveController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('restrict:admin,user');
    }

    public function index()
    {
        $meetings = CommitteeMeeting::paginate(10);
        // return $meetings;
        return view('committee.meeting.archive', compact('meetings'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        $meeting = CommitteeMeeting::findOrFail($id);
        return view('committee.meeting.view', compact('meeting') );
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
