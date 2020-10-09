<?php

namespace App\Http\Controllers;

use App\Remark;
use App\Category;
use App\Committee;
use Carbon\Carbon;
use App\BoardAgenda;
use App\CommitteeAgenda;
use App\CommitteeMeeting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommitteeAgendaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('restrict:admin', ['only' => ['create', 'update', 'store', 'destroy', 'copy']]);

        $this->categories = Category::all();
        $this->committees = Committee::where('id', '>', 0)->get();
        $this->types = Remark::all()->unique('name');
    }

    public function index()
    {
        return null;
    }

    public function create()
    {
        $categories = $this->categories;
        $types = $this->types;
        $committees = $this->committees;

        return view('committee.agenda.create', compact('categories', 'types', 'committees'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'uid' => 'required|regex:/^[0-9]+\.[0-9]+$/i',
            'subject' => 'required',
            'category' => 'required',
            'type' => 'required',
            'committee_id' => 'required',
        ]);

        $request->validate([
            'agenda' => 'mimetypes:application/pdf',
            'annexure' => 'mimetypes:application/pdf',
            'presentation' => 'mimetypes:application/pdf',
            'notesheet' => 'mimetypes:application/pdf',
        ]);

        if(CommitteeAgenda::where('uid', $request->uid)->first()) {
            return redirect()->back()->with('error', 'Unique ID already exists');
        }

        $agenda = CommitteeAgenda::create($validated);

        $folder_id = $agenda->id;
        if ($request->hasFile('agenda')) {
            $agenda_name = "agenda_" . Carbon::now()->format('YmdHis') . "_" . $request->file('agenda')->getClientOriginalName();
            $agenda_path = $request->file('agenda')->storeAs("public/uploads/committee/agenda/$folder_id", $agenda_name);
            $agenda->agenda_url = explode("/", $agenda_path, 2)[1];
        }
        if ($request->hasFile('annexure')) {
            $annexure_name = "annexure_" . Carbon::now()->format('YmdHis') . "_" . $request->file('annexure')->getClientOriginalName();
            $annexure_path = $request->file('annexure')->storeAs("public/uploads/committee/agenda/$folder_id", $annexure_name);
            $agenda->annexure_url = explode("/", $annexure_path, 2)[1];
        }
        if ($request->hasFile('notesheet')) {
            $notesheet_name = "notesheet_" . Carbon::now()->format('YmdHis') . "_" . $request->file('notesheet')->getClientOriginalName();
            $notesheet_path = $request->file('notesheet')->storeAs("public/uploads/committee/agenda/$folder_id", $notesheet_name);
            $agenda->notesheet_url = explode("/", $notesheet_path, 2)[1];
        }
        if ($request->hasFile('presentation')) {
            $presentation_name = "presentation_" . Carbon::now()->format('YmdHis') . "_" . $request->file('presentation')->getClientOriginalName();
            $presentation_path = $request->file('presentation')->storeAs("public/uploads/committee/agenda/$folder_id", $presentation_name);
            $agenda->presentation_url = explode("/", $presentation_path, 2)[1];
        }
        if ($request->hasFile('supplementary')) {
            $supplementary_name = "supplementary_" . Carbon::now()->format('YmdHis') . "_" . $request->file('supplementary')->getClientOriginalName();
            $supplementary_path = $request->file('supplementary')->storeAs("public/uploads/committee/agenda/$folder_id", $supplementary_name);
            $agenda->supplementary_url = explode("/", $supplementary_path, 2)[1];
        }

        $agenda->save();

        return redirect('/committee/agenda/create')->with('success', "Committee agenda $agenda->uid succesfully created");
    }

    public function show($id)
    {
        $agenda = CommitteeAgenda::findOrFail($id);

        $categories = $this->categories;
        $types = $this->types;
        $committees = $this->committees;

        return view('committee.agenda.show', compact('agenda', 'categories', 'types', 'committees'));
    }

    public function edit($id)
    {
        return null;
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'uid' => 'required|regex:/^[0-9]+\.[0-9]+$/i',
            'subject' => 'required',
            'category' => 'required',
            'type' => 'required',
            'committee_id' => 'required',
        ]);

        $request->validate([
            'agenda' => 'mimetypes:application/pdf',
            'annexure' => 'mimetypes:application/pdf',
            'presentation' => 'mimetypes:application/pdf',
            'notesheet' => 'mimetypes:application/pdf',
        ]);

        $agenda = CommitteeAgenda::find($id);
        // $boardAgenda = BoardAgenda::where('uid', $agenda->board_uid)->first();

        $agenda->uid = $request->uid;
        $agenda->subject = $request->subject;
        $agenda->category = $request->category;
        $agenda->type = $request->type;
        $agenda->committee_id = $request->committee_id;
        // $agenda->board_uid = $request->board_uid;

        $folder_id = $agenda->id;
        if ($request->hasFile('agenda')) {
            $agenda_name = "agenda_" . Carbon::now()->format('YmdHis') . "_" . $request->file('agenda')->getClientOriginalName();
            $agenda_path = $request->file('agenda')->storeAs("public/uploads/committee/agenda/$folder_id", $agenda_name);
            $agenda->agenda_url = explode("/", $agenda_path, 2)[1];
        }
        if ($request->hasFile('annexure')) {
            $annexure_name = "annexure_" . Carbon::now()->format('YmdHis') . "_" . $request->file('annexure')->getClientOriginalName();
            $annexure_path = $request->file('annexure')->storeAs("public/uploads/committee/agenda/$folder_id", $annexure_name);
            $agenda->annexure_url = explode("/", $annexure_path, 2)[1];
        }
        if ($request->hasFile('notesheet')) {
            $notesheet_name = "notesheet_" . Carbon::now()->format('YmdHis') . "_" . $request->file('notesheet')->getClientOriginalName();
            $notesheet_path = $request->file('notesheet')->storeAs("public/uploads/committee/agenda/$folder_id", $notesheet_name);
            $agenda->notesheet_url = explode("/", $notesheet_path, 2)[1];
        }
        if ($request->hasFile('presentation')) {
            $presentation_name = "presentation_" . Carbon::now()->format('YmdHis') . "_" . $request->file('presentation')->getClientOriginalName();
            $presentation_path = $request->file('presentation')->storeAs("public/uploads/committee/agenda/$folder_id", $presentation_name);
            $agenda->presentation_url = explode("/", $presentation_path, 2)[1];
        }
        if ($request->hasFile('supplementary')) {
            $supplementary_name = "supplementary_" . Carbon::now()->format('YmdHis') . "_" . $request->file('supplementary')->getClientOriginalName();
            $supplementary_path = $request->file('supplementary')->storeAs("public/uploads/committee/agenda/$folder_id", $supplementary_name);
            $agenda->supplementary_url = explode("/", $supplementary_path, 2)[1];
        }
        $agenda->save();


        // if ($boardAgenda) {
        //     $boardAgenda->agenda_url = $agenda->agenda_url;
        //     $boardAgenda->annexure_url = $agenda->annexure_url;
        //     $boardAgenda->notesheet_url = $agenda->notesheet_url;
        //     $boardAgenda->presentation_url = $agenda->presentation_url;
        //     $boardAgenda->supplementary_url = $agenda->supplementary_url;
        //     $boardAgenda->save();
        // }

        return redirect()->back()->with('success', "Committee agenda $agenda->uid succesfully updated");
    }

    public function destroy($id)
    {
        $agenda = CommitteeAgenda::findOrFail($id);
        if (!Auth::user()->isSecretary() && $agenda->visibility) {
            abort(500);
        }
        $agenda->delete();
        return redirect('/committee/meeting')->with('success', 'Committee agenda succesfully deleted!');
    }

    public function copy(Request $request)
    {

        $request->validate([
            'agendas' => 'required'
        ]);

        $agendas = BoardAgenda::find($request->agendas);

        foreach ($agendas as $agenda) {

            $meeting = CommitteeMeeting::where('status', 'scheduled')->where('committee_id', $agenda->committee_id)->first();

            if ($meeting) {

                // $uid = $meeting->agendas->isNotEmpty() ? explode('.', $meeting->agendas->sortByDesc('uid')->first()->uid )[1] : 0 ;

                CommitteeAgenda::create([
                    'uid' => $meeting->name . ".?",
                    'board_uid' => $agenda->uid,
                    'subject' => $agenda->subject,
                    'category' => $agenda->category,
                    'type' => $agenda->type,
                    'committee_id' => $agenda->committee_id,

                    'agenda_url' => $agenda->agenda_url,
                    'annexure_url' => $agenda->annexure_url,
                    'presentation_url' => $agenda->presentation_url,
                    'notesheet_url' => $agenda->notesheet_url,
                    'supplementary_url' => $agenda->supplementary_url,
                ]);

                $agenda->copied_to_committee = true;
                $agenda->save();
            } else {
                return redirect('/board/home/2')->with('error', 'Meeting not created!');
            }
        }

        return redirect('/board/home/2')->with('success', 'All agendas copied to respective committees!');
    }

    public function view($id, $document)
    {

        $agenda = CommitteeAgenda::findOrFail($id);
        $param = $document . '_url';

        if ($agenda[$param]) {
            // $url = '/storage/' . $agenda[$param];
            $portal = 'committee';
            return view('webviewer.download', compact('id', 'portal', 'agenda', 'document'));
        }

        abort(404);
    }

    public function deleteDocument($id, $document)
    {

        $agenda = CommitteeAgenda::findOrFail($id);
        $url = $document . "_url";
        $agenda->$url = null;
        $agenda->save();

        return 'success';
    }
}
