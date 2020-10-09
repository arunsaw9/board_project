<?php

namespace App\Http\Controllers;

use App\User;
use App\BoardMeeting;
use App\CommitteeAgenda;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\QueryException;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('restrict:admin', ['only' => ['create', 'store', 'update', 'destroy', 'agenda']]);
    }

    public function index()
    {
        $users = User::all();

        return view('user.index', compact('users'));
    }

    public function create()
    {
        return view('user.create');
    }

    public function store(Request $request)
    {
        $rules = [
            'email' => 'required|email',
            'username' => 'required|numeric',
            // 'password' => 'required|regex:/^(?=.*[A-Z].*[A-Z])(?=.*[!@#$&*])(?=.*[0-9].*[0-9])(?=.*[a-z].*[a-z].*[a-z]).{8}$/i',
            // 'password' => ['required', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{8,})/i'],
            'name' => 'required',
            'designation' => 'nullable',
            'mobile' => 'required|numeric',
            'role' => 'required',
        ];

        $customMessages = [
            'password.regex' => 'Password should be a strong password of length 8 containing atleast one Capital letter, Number and a Symbol'
        ];

        $validated = $this->validate($request, $rules, $customMessages);

        try {
            User::create([
                'name' => $validated['name'],
                'username' => $validated['username'],
                'email' => $validated['email'],
                'role' => $validated['role'],
                'designation' => $validated['designation'],
                'password' => Hash::make('Board@123!'),
                'api_token' => Str::random(60),
                'mobile' => $validated['mobile'],
            ]);
        } catch (QueryException $e) {
            return redirect()->back()->with('error', 'Email or username already exists!');
        }

        return redirect()->back()->with('success', 'User added succesfully!');
    }

    public function show($id)
    {

        if (!Auth::user()->hasRole('admin')) {
            if (Auth::user()->id != $id) {
                abort(404);
            }
        }

        $user = User::findOrFail($id);
        $meeting = BoardMeeting::where('status', 'scheduled')->first();
        $committeeAgendas = CommitteeAgenda::where('status', 'takenup')->get();

        return view('user.show', compact('user', 'meeting', 'committeeAgendas'));
    }

    public function edit($id)
    {
        return $id;
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'email' => 'required|email',
            'username' => 'required|numeric',
            'name' => 'required',
            'designation' => 'nullable',
            'role' => 'required',
            'committees' => 'nullable',
            'mobile' => 'nullable|numeric',
        ]);

        $user = User::findOrFail($id);
        $user->email = $request->email;
        $user->username = $request->username;
        $user->name = $request->name;
        $user->role = $request->role;
        $user->mobile = $request->mobile;
        $user->designation = $request->designation;
        $user->mailnotifications = $request->mailnotifications == 'on' ? true : false;
        $user->smsnotifications = $request->smsnotifications == 'on' ? true : false;
        $user->save();

        if ($request->committees) {
            $user->committees()->sync($request->committees);
        }

        return redirect()->back()->with('success', 'User details updated!');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect('/user')->with('success', 'User deleted!');
    }

    public function agenda(Request $request, $id)
    {

        $user = User::find($id);

        if ($request->type == 'board') {
            $user->boardAgendas()->sync($request->agendas);
        } else {
            $user->committeeAgendas()->sync($request->agendas);
        }

        return redirect()->back()->with('success', "Succesfully granted access to the selected agendas!");
    }

    public function reset(Request $request, $id)
    {

        $rules = [
            // 'password' => ['required', 'regex:/^(?=.*[A-Z].*[A-Z])(?=.*[!@#$&*])(?=.*[0-9].*[0-9])(?=.*[a-z].*[a-z].*[a-z]).{8}$/i', 'confirmed'],
            // 'password' => ['required', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{8,})/i', 'confirmed' ],
            'password' => ['required', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{8,})/i'],
        ];

        $customMessages = [
            'password.regex' => 'Password should be a strong password of length 8 containing atleast one Capital letter, Number and a Symbol'
        ];

        $validated = $this->validate($request, $rules, $customMessages);

        $user = User::findOrFail($id);

        $old_password =  base64_decode(base64_decode(base64_decode(explode(".", $request->old_password)[1])));
        if (!Hash::check($old_password, $user->password)) {
            return redirect()->back()->with('error', 'Old password is incorrect');
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->back()->with('success', "Succesfully changed password!");
    }
}
