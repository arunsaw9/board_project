<?php

namespace App\Http\Controllers;

use App\Remark;
use App\Category;
use App\Committee;
use Carbon\Carbon;
use App\BoardAgenda;
use App\CommitteeAgenda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class BoardAgendaController extends Controller
{
    protected $categories;
    protected $types;
    protected $committees;

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('restrict:admin', ['only' => ['create', 'update', 'store', 'destroy', 'deleteDocument']]);

        $this->categories = Category::all();
        $this->committees = Committee::all();
        $this->types = Remark::all()->unique('name');
    }

    public function index()
    {
        return BoardAgenda::all();
    }

    public function create()
    {
        $categories = $this->categories;
        $types = $this->types;
        $committees = $this->committees;

        return view('board.agenda.create', compact('categories', 'types', 'committees'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'uid' => 'required|regex:/^[0-9]+\.[A-Z]+[0-9]+\.[0-9]+$/i',
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

        $agenda = BoardAgenda::create($validated);

        $folder_id = $agenda->id;
        if ($request->hasFile('agenda')) {
            $agenda_name = "agenda_" . Carbon::now()->format('YmdHis') . "." . $request->file('agenda')->getClientOriginalExtension();
            $agenda_path = $request->file('agenda')->storeAs("public/uploads/board/agenda/$folder_id", $agenda_name);
            $agenda->agenda_url = explode("/", $agenda_path, 2)[1];
        }
        if ($request->hasFile('annexure')) {
            $annexure_name = "annexure_" . Carbon::now()->format('YmdHis') . "." . $request->file('annexure')->getClientOriginalExtension();
            $annexure_path = $request->file('annexure')->storeAs("public/uploads/board/agenda/$folder_id", $annexure_name);
            $agenda->annexure_url = explode("/", $annexure_path, 2)[1];
        }
        if ($request->hasFile('notesheet')) {
            $notesheet_name = "notesheet_" . Carbon::now()->format('YmdHis') . "." . $request->file('notesheet')->getClientOriginalExtension();
            $notesheet_path = $request->file('notesheet')->storeAs("public/uploads/board/agenda/$folder_id", $notesheet_name);
            $agenda->notesheet_url = explode("/", $notesheet_path, 2)[1];
        }
        if ($request->hasFile('presentation')) {
            $presentation_name = "presentation_" . Carbon::now()->format('YmdHis') . "." . $request->file('presentation')->getClientOriginalExtension();
            $presentation_path = $request->file('presentation')->storeAs("public/uploads/board/agenda/$folder_id", $presentation_name);
            $agenda->presentation_url = explode("/", $presentation_path, 2)[1];
        }
        if ($request->hasFile('supplementary')) {
            $supplementary_name = "supplementary_" . Carbon::now()->format('YmdHis') . "." . $request->file('supplementary')->getClientOriginalExtension();
            $supplementary_path = $request->file('supplementary')->storeAs("public/uploads/board/agenda/$folder_id", $supplementary_name);
            $agenda->supplementary_url = explode("/", $supplementary_path, 2)[1];
        }

        $agenda->save();

        return redirect('/board/agenda/create')->with('success', "Board agenda $agenda->uid succesfully created");
    }

    public function show($id)
    {
        $agenda = BoardAgenda::findOrFail($id);

        $categories = $this->categories;
        $types = $this->types;
        $committees = $this->committees;

        return view('board.agenda.show', compact('agenda', 'categories', 'types', 'committees'));
    }

    public function edit($id)
    {
        return $id;
    }

    public function update(Request $request, $id)
    {

        $request->validate([
            'uid' => 'required|regex:/^[0-9]+\.[A-Z]+[0-9]+\.[0-9]+$/i',
            'subject' => 'required',
            'category' => 'required',
            'type' => 'required',
            'committee_id' => 'required',
            'agenda' => 'mimetypes:application/pdf',
            'annexure' => 'mimetypes:application/pdf',
            'presentation' => 'mimetypes:application/pdf',
            'notesheet' => 'mimetypes:application/pdf',
            'supplementary' => 'mimetypes:application/pdf',
        ]);

        $agenda = BoardAgenda::find($id);
        // $committeeAgenda = CommitteeAgenda::where('board_uid', $agenda->uid)->first();

        $agenda->uid = $request->uid;
        $agenda->subject = $request->subject;
        $agenda->category = $request->category;
        $agenda->type = $request->type;
        $agenda->priority = $request->priority;
        $agenda->committee_id = $request->committee_id;

        $folder_id = $agenda->id;
        if ($request->hasFile('agenda')) {
            $agenda_name = "agenda_" . Carbon::now()->format('YmdHis') . "." . $request->file('agenda')->getClientOriginalExtension();
            $agenda_path = $request->file('agenda')->storeAs("public/uploads/board/agenda/$folder_id", $agenda_name);
            $agenda->agenda_url = explode("/", $agenda_path, 2)[1];
        }
        if ($request->hasFile('annexure')) {
            $annexure_name = "annexure_" . Carbon::now()->format('YmdHis') . "." . $request->file('annexure')->getClientOriginalExtension();
            $annexure_path = $request->file('annexure')->storeAs("public/uploads/board/agenda/$folder_id", $annexure_name);
            $agenda->annexure_url = explode("/", $annexure_path, 2)[1];
        }
        if ($request->hasFile('notesheet')) {
            $notesheet_name = "notesheet_" . Carbon::now()->format('YmdHis') . "." . $request->file('notesheet')->getClientOriginalExtension();
            $notesheet_path = $request->file('notesheet')->storeAs("public/uploads/board/agenda/$folder_id", $notesheet_name);
            $agenda->notesheet_url = explode("/", $notesheet_path, 2)[1];
        }
        if ($request->hasFile('presentation')) {
            $presentation_name = "presentation_" . Carbon::now()->format('YmdHis') . "." . $request->file('presentation')->getClientOriginalExtension();
            $presentation_path = $request->file('presentation')->storeAs("public/uploads/board/agenda/$folder_id", $presentation_name);
            $agenda->presentation_url = explode("/", $presentation_path, 2)[1];
        }
        if ($request->hasFile('supplementary')) {
            $supplementary_name = "supplementary_" . Carbon::now()->format('YmdHis') . "." . $request->file('supplementary')->getClientOriginalExtension();
            $supplementary_path = $request->file('supplementary')->storeAs("public/uploads/board/agenda/$folder_id", $supplementary_name);
            $agenda->supplementary_url = explode("/", $supplementary_path, 2)[1];
        }

        $agenda->save();

        // if ($committeeAgenda) {
        //     if ($committeeAgenda->board_uid != $agenda->uid) {
        //         $committeeAgenda->board_uid = $agenda->uid;
        //         $committeeAgenda->category = $agenda->category;
        //         $committeeAgenda->type = $agenda->type;
        //     }
        //     $committeeAgenda->agenda_url = $agenda->agenda_url;
        //     $committeeAgenda->annexure_url = $agenda->annexure_url;
        //     $committeeAgenda->notesheet_url = $agenda->notesheet_url;
        //     $committeeAgenda->presentation_url = $agenda->presentation_url;
        //     $committeeAgenda->supplementary_url = $agenda->supplementary_url;
        //     $committeeAgenda->save();
        // }

        return redirect('/board/meeting/admin')->with('success', "Board agenda $agenda->uid succesfully updated");
    }

    public function destroy($id)
    {
        $agenda = BoardAgenda::findOrFail($id);

        if (!Auth::user()->isSecretary() && $agenda->visibility) {
            abort(500);
        }

        $agenda->delete();

        return redirect('/board/meeting/admin')->with('success', 'Board agenda succesfully deleted!');
    }

    public function view($id, $document)
    {

        $agenda = BoardAgenda::findOrFail($id);
        $param = $document . '_url';

        if ($agenda[$param]) {
            // $url = '/storage/' . $agenda[$param];
            $portal = 'board';
            // return view('webviewer.view', compact('url', 'portal', 'agenda', 'document') );

            return view('webviewer.download', compact('id', 'portal', 'agenda', 'document'));
        }

        abort(404);
    }

    public function uidGen($category, $type)
    {
        $agenda = BoardAgenda::where('category', $category)->where('type', $type)->where('status', '!=', 'archive')->orderByDesc('uid')->first();
        $serial = $agenda ? explode('.', $agenda->uid)[2] : 0;
        return ($serial + 1);
    }

    public function deleteDocument($id, $document)
    {
        $agenda = BoardAgenda::findOrFail($id);
        $url = $document . "_url";
        $agenda->$url = null;
        $agenda->save();

        return 'success';
    }
}
