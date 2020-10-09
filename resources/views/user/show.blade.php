@extends('layouts.app')

@section('content')
    
<div class="container mt-2">

        <div class="card shadow-sm">
            <div class="card-body">
                <h3 class="card-title text-primary"> <v-icon color="primary">mdi-account-edit</v-icon> Update User </h3>

                <form action="/user/{{ $user->id }}" method="post">
                @csrf 
                @method('PATCH')
                    <div class="row">
                        <div class="col-6">
                            <label for="name">Name</label>
                            <input type="text" name="name" value="{{ $user->name }}" class="form-control" required>
                        </div>
                        <div class="col-6">
                            <label for="designation">Designation</label>
                            <input type="text" name="designation" value="{{ $user->designation }}" class="form-control">
                        </div>
                        <div class="col-6">
                            <label for="username">Login Username</label>
                            <input type="text" name="username" value="{{ $user->username }}" class="form-control">
                        </div>
                        <div class="col-6">
                            <label for="email">Email</label>
                            <input type="email" name="email" value="{{ $user->email }}" class="form-control">
                        </div>
                        <div class="col-6">
                            <label for="mobile">Mobile No</label>
                            <input type="text" name="mobile" value="{{ $user->mobile }}" class="form-control">
                        </div>
                        {{-- <div class="col-6">
                            <label for="password">Default Password</label>
                            <input type="password" name="password" value="{{ $user->name }}" class="form-control" required>
                        </div> --}}
                        @if( Auth::user()->hasRole('admin'))
                            <div class="col-6">
                                <label for="role">Role</label>
                                <select name="role" id="role" class="form-control">
                                    <option value="invitee" @if( $user->role == 'invitee' ) selected @endif >Invitee</option>
                                    <option value="user" @if( $user->role == 'user' ) selected @endif >User</option>
                                    {{-- <option value="special" @if( $user->role == 'special' ) selected @endif >Special Invitee</option> --}}
                                    <option value="admin" @if( $user->role == 'admin' ) selected @endif >Admin</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label for="committees">Committees</label>
                                {{-- <select name="committees[]" id="committees" class="form-control" multiple>
                                    @foreach (\App\Committee::where('id', '>', 0)->get() as $committee)
                                        <option value="{{ $committee->id }}" @if( $user->committees->contains($committee)) selected @endif> {{ $committee->name }}</option>
                                    @endforeach
                                </select> --}}
                                @foreach (\App\Committee::where('id', '>', 0)->get() as $committee)
                                    <div class="form-check">
                                        <input class="form-check-input" name="committees[]" id="cb-{{ $committee->id }}" type="checkbox" value="{{ $committee->id }}" @if( $user->committees->contains($committee)) checked @endif>
                                        <label class="form-check-label" for="cb-{{ $committee->id }}">
                                            {{ $committee->name }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        @else 

                        <input type="hidden" name="role" value="{{ $user->role }}" >

                        <div class="col-12">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="mailSwitch" name="mailnotifications" @if($user->mailnotifications) checked @endif >
                                <label class="custom-control-label" for="mailSwitch">Enable Mail Notifications</label>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="smsSwitch" name="smsnotifications" @if($user->smsnotifications) checked @endif>
                                <label class="custom-control-label" for="smsSwitch">Enable SMS Notifications</label>
                            </div>
                        </div>
                            
                        @endif
                        <div class="col-12">
                            <button class="btn btn-primary" type="submit">Update</button>
                            @if( Auth::user()->hasRole('admin') )
                                <button class="btn btn-outline-danger" type="button" onclick="document.getElementById('form-delete-user').submit()" >Delete</button>
                            @endif
                        </div>
                    </div>
                </form>
                <form action="/user/{{ $user->id }}" method="post" class="d-none" id="form-delete-user">
                    @csrf 
                    @method('DELETE')
                </form>
            </div>
        </div>

        @if( Auth::user()->id == $user->id ) 

            <div class="card shadow-sm mt-4">
                <div class="card-header">
                    Password Reset
                </div>
                <div class="card-body">
                    <form id="form-password-reset" action="/user/{{ $user->id }}/reset" method="post">
                    @csrf
                    @method('PATCH')
                        <div class="row">
                            <div class="col-6">
                                <label for="old-password">Old Password</label>
                                <input type="password" id="old_password" name="old_password" class="form-control" placeholder="********">
                            </div>
                            <div class="col-6">
                                <label for="password">New Password</label>
                                <input type="password" id="password" name="password" class="form-control" placeholder="********">
                            </div>
                            <div class="col-6">
                                <label for="email">Confirm Password</label>
                                <input type="password" id="confirmation" class="form-control" placeholder="********">
                                {{-- <input type="password" name="password_confirmation" class="form-control" placeholder="********"> --}}
                            </div>
                            <input type="hidden" id="token" name="_g-token">
                            <div class="col-12">
                                <button type="button" id="btn-password-reset" class="btn btn-outline-primary">Update</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        @endif

        @if( $user->role == 'invitee' && Auth::user()->hasRole('admin') )
            <div class="card shadow-sm my-4">
                <div class="card-header"> User Board Agendas <small>(only for invitees)</small> </div>
                <div class="card-body pa-0">

                    @if( $meeting->agendas->isNotEmpty() )
                    <form action="/user/{{ $user->id }}/agenda" method="post">
                    @csrf
                    <input type="hidden" name="type" value="board">

                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th style="width:50%">Subject</th>
                                    <th>Category</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($meeting->agendas as $agenda)
                                    <tr>
                                        <td> 
                                            <input type="checkbox" name="agendas[]" value="{{ $agenda->id }}"
                                                @if( $user->boardAgendas->contains($agenda) ) checked @endif
                                            >
                                        </td>
                                        <td> {{ $agenda->subject }}</td>
                                        <td> {{ $agenda->category }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <button class="btn btn-outline-primary ma-4" >Grant Access</button>
                    </form>
                    @else
                        <div class="alert alert-danger ma-4" role="alert">
                            No agendas in the meeting
                        </div>
                    @endif

                </div>
            </div>

            {{-- COMMITTEE AGENDAS --}}
            <div class="card shadow-sm my-4">
                <div class="card-header"> User Committee Agendas <small>(only for invitees)</small> </div>
                <div class="card-body pa-0">

                    @if( $committeeAgendas->isNotEmpty() )
                    <form action="/user/{{ $user->id }}/agenda" method="post">
                    @csrf
                    <input type="hidden" name="type" value="committee">

                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th style="width:50%">Subject</th>
                                    <th>Category</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($committeeAgendas as $agenda)
                                    <tr>
                                        <td> 
                                            <input type="checkbox" name="agendas[]" value="{{ $agenda->id }}"
                                                @if( $user->committeeAgendas->contains($agenda) ) checked @endif
                                            >
                                        </td>
                                        <td> {{ $agenda->subject }}</td>
                                        <td> {{ $agenda->category }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <button class="btn btn-outline-primary ma-4" >Grant Access</button>
                    </form>
                    @else
                        <div class="alert alert-danger ma-4" role="alert">
                            No agendas in the meeting
                        </div>
                    @endif

                </div>
            </div>
        @endif
    </div>

@endsection