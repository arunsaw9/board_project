@extends('layouts.app')


@section('content')

<div class="pt-8 mb-4">
    <ul class="nav nav-tabs pl-8">
        <li class="nav-item">
            <a class="nav-link @if( $tab == 1 ) active @endif" href="/committee/meeting/{{ $meeting->id }}">Meeting</a>
        </li>
        <li class="nav-item">
            <a class="nav-link @if( $tab == 2 ) active @endif" href="/committee/meeting/{{ $meeting->id }}/users">Members</a>
        </li>
    </ul>

    <div class="container mt-2">

        @if( $tab == 1 )
        <div class="card">
            <div class="card-header">
                Scheduled Meeting
            </div>
            <div class="card-body">
                <form action="/committee/meeting/{{ $meeting->id }}" method="post">
                @csrf 
                @method('PATCH')
                    <div class="row">
                        <div class="col-6">
                            <label for="name">Meeting Name</label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="name" value="{{ $meeting->name }}"
                                    @if( $meeting->agendas->count() > 0 && $agendas->isEmpty() ) disabled @endif
                                >
                                <div class="input-group-append">
                                    <span class="input-group-text">{{ $meeting->committee->name }} Meeting</span>
                                </div>
                            </div>
                            @if ($errors->has('name')) 
                                <small class="text-danger"> Meeting name should be numeric</small>
                            @endif
                        </div>
                        <div class="col-6">
                            <label for="date">Date</label>
                            <input type="date" class="form-control" name="date" value="{{ $meeting->date }}">
                        </div>
                        <div class="col-6">
                            <label for="time">Time</label>
                            <input type="time" class="form-control" name="time" value="{{ $meeting->time }}">
                        </div>
                        <div class="col-6">
                            <label for="place">Place</label>
                            <input type="text" class="form-control" name="place" value="{{ $meeting->place }}">
                        </div>
                        <div class="col-12">
                            <button class="btn btn-primary">Update</button>
                            <a href="/committee/meeting/user/{{ $meeting->committee_id }}" target="_blank" class="btn btn-outline-primary">Member's View</a>
                            {{-- <button class="btn btn-outline-danger" type="button">End Meeting</button> --}}
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="card my-4">
            <div class="card-header">
                Meeting Agendas
            </div>
            <div class="card-body pa-0">
                @if( $agendas->isNotEmpty() )
                <form action="/committee/meeting/action/circulate" method="post">
                    <input type="hidden" name="committee_id" value="{{ $meeting->committee_id }}" >
                @csrf
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th><input type="checkbox" id="cb-select-all"></th>
                                <th>UID</th>
                                <th style="width:60%">SUBJECT</th>
                                <th>CATEGORY</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($agendas as $agenda)
                                <tr>
                                    <td> <input class="checkBox" type="checkbox" name="agendas[]" value="{{ $agenda->id }}"> </td>
                                    <td>
                                        <div class="d-flex">
                                            <a href="/committee/agenda/{{ $agenda->id }}" class="mr-2"> {{ $agenda->uid }} </a> 
                                            <v-icon small> {{ $agenda->visibility ? 'mdi-eye' : 'mdi-eye-off' }} </v-icon>
                                        </div> 
                                    </td>
                                    <td> 
                                        <div class="row"> 
                                            <div class="col-xl-8 py-0"> {{ $agenda->subject }} </div>
                                            <div class="col-xl-4 py-0">
                                                <span class="mr-4">
                                                    {{-- @if($agenda->agenda_url) <v-btn href="/committee/agenda/{{$agenda->id}}/agenda/view" target="_blank" icon color="red darken-2"> <v-icon>mdi-file-outline</v-icon></v-btn> @endif
                                                    @if($agenda->annexure_url) <v-btn href="/committee/agenda/{{$agenda->id}}/annexure/view" target="_blank" icon color="blue" > <v-icon>mdi-animation-outline</v-icon></v-btn> @endif
                                                    @if($agenda->presentation_url) <v-btn href="/committee/agenda/{{$agenda->id}}/presentation/view" target="_blank" icon color="orange"> <v-icon>mdi-presentation</v-icon></v-btn> @endif
                                                    @if($agenda->notesheet_url) <v-btn href="/committee/agenda/{{$agenda->id}}/notesheet/view" target="_blank" icon color="green"> <v-icon>mdi-book-open-outline</v-icon></v-btn> @endif --}}
                                                    @if($agenda->agenda_url) <v-btn href="/committee/agenda/{{$agenda->id}}/agenda/view" target="_blank" icon color="red darken-2"> <v-icon>mdi-file</v-icon></v-btn> @endif
                                                    @if($agenda->annexure_url) <v-btn href="/committee/agenda/{{$agenda->id}}/annexure/view" target="_blank" icon color="blue" > <v-icon>mdi-alpha-a-circle</v-icon></v-btn> @endif
                                                    @if($agenda->presentation_url) <v-btn href="/committee/agenda/{{$agenda->id}}/presentation/view" target="_blank" icon color="orange"> <v-icon>mdi-alpha-p-circle</v-icon></v-btn> @endif
                                                    @if($agenda->notesheet_url) <v-btn href="/committee/agenda/{{$agenda->id}}/notesheet/view" target="_blank" icon color="green"> <v-icon>mdi-alpha-n-circle</v-icon></v-btn> @endif
                                                    @if($agenda->supplementary_url) <v-btn href="/committee/agenda/{{$agenda->id}}/supplementary/view" target="_blank" icon color="purple"> <v-icon>mdi-alpha-s-circle</v-icon></v-btn> @endif
                                                </span>
                                            </div>
                                        </div>
                                        {{-- <a href="/storage/{{ $agenda->agenda_url }}" class="btn btn-sm btn-outline-primary @if( ! $agenda->agenda_url ) disabled  @endif" target="_blank">View Agenda</a>
                                        <a href="/storage/{{ $agenda->annexure_url }}" class="btn btn-sm btn-outline-primary @if( ! $agenda->annexure_url ) disabled  @endif" target="_blank">View Annexure</a> --}}
                                    </td>
                                    <td> {{ $agenda->category }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @if(Auth::user()->isSecretary())
                        <button formaction="/committee/meeting/action/circulate" class="btn btn-primary ma-4">Circulate</button>
                    @endif
                    <button formaction="/committee/meeting/action/archive" class="btn btn-success mt-4 mr-4 ml-1 float-right">Archive</button>
                    <button formaction="/committee/meeting/action/defer" class="btn btn-danger mt-4 float-right">Defer</button>
                </form>
                @else 
                    <div class="ma-4 d-flex align-items-center"> Action taken on all agendas. Please 
                        <button id="btn-end-meeting" class="btn btn-sm btn-outline-danger mx-2">Click here</button>
                        <form id="form-end-meeting" class="d-none" action="/committee/meeting/{{ $meeting->id }}" method="post">
                        @csrf 
                        @method('DELETE')
                            {{-- <button id="btn-end-committee-meeting" class="btn btn-sm btn-outline-danger mx-2">Click here</button> --}}
                        </form>
                        to end this meeting
                    </div>
                @endif
            </div>
        </div>
        @else 

        <div class="card">
            <div class="card-header"> Meeting Members </div>
            <div class="card-body">
                <form action="/committee/meeting/{{ $meeting->id }}/users" method="post">
                @csrf
                    <div class="mb-4">
                        {{-- <select id="users" name="users[]" multiple class="form-control">
                            @foreach (\App\User::all() as $user)
                                <option value="{{ $user->id }}" @if( $meeting->users->contains($user)) selected @endif> {{ $user->name }} </option>
                            @endforeach
                        </select> --}}
                        @foreach (\App\User::all() as $user)
                            <div class="form-check">
                                <input class="form-check-input" name="users[]" id="cb-{{ $user->id }}" type="checkbox" value="{{ $user->id }}" @if( $meeting->users->contains($user)) checked @endif>
                                <label class="form-check-label" for="cb-{{ $user->id }}">
                                    {{ $user->name }}
                                </label>
                            </div>
                        @endforeach
                        
                    </div>
                    <button class="btn btn-primary mt-2">Submit</button>
                </form>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-header">
                MEETING INVITEES
            </div>
            <div class="card-body">
                <ul>
                    @foreach (\App\User::where('role','invitee')->get() as $user)
                        <li> <a href="/user/{{ $user->id }}"> {{ $user->name }} </a> </li>
                    @endforeach
                </ul>
            </div>
        </div>

        @endif

    </div>
</div>
    
@endsection