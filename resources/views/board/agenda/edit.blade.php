@extends('layouts.app')

@section('content')
    
    <div class="container">

        <div class="card">
            {{-- <div class="card-header text-primary">
                {{ $agenda->subject }}
            </div> --}}
            <div class="card-body">
                <h3 class="card-title text-primary"> <v-icon color="primary">mdi-view-list</v-icon> {{ $agenda->subject }} </h3>
                {{-- <form action="/board/agenda/{{ $agenda->id }}" method="post" enctype="multipart/form-data"> --}}
                {{-- @method('PATCH')
                @csrf  --}}

                    <div class="row">
                        {{-- <div class="col-6">
                            <label for="category">Category</label>
                            <select name="category" id="category" class="form-control">
                                @foreach ($categories as $category)
                                    <option value="{{ $category }}" @if( $category == $agenda->category ) selected @endif >{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div> --}}
                        <div class="col-6">
                            <label for="category">Category</label>
                            <input type="text" class="form-control" readonly value="{{ $agenda->category }}">
                        </div>
                        {{-- <div class="col-6">
                            <label for="type">Type</label>
                            <select name="type" id="type" class="form-control">
                                @foreach ($types as $type)
                                    <option @if( $type == $agenda->type ) selected @endif >{{ $type }}</option>
                                @endforeach 
                            </select>
                        </div> --}}
                        <div class="col-6">
                            <label for="category">Remarks</label>
                            <input type="text" class="form-control" readonly value="{{ $agenda->type }}">
                        </div>
                        <div class="col-6">
                            <label for="uid">Unique ID</label>
                            <input readonly type="text" class="form-control" name="uid" value="{{ $agenda->uid }}">
                        </div>
                        {{-- <div class="col-6">
                            <label for="committee">Recommended Through</label>
                            <select name="committee_id" id="committee_id" class="form-control">
                                @foreach ($committees as $committee)
                                    <option @if( $committee->id == $agenda->committee_id ) selected @endif value={{ $committee->id }}>{{ $committee->name }}</option>
                                @endforeach
                            </select>
                        </div> --}}
                        <div class="col-6">
                            <label for="committee">Recommended Through</label>
                            <input readonly type="text" class="form-control" name="committee" value="{{ $agenda->committee->name }}">
                        </div>
                        <div class="col-12">
                            <label for="subject">Agenda Subject</label>
                            <textarea readonly value="{{ $agenda->subject }}" name="subject" name="subject" rows="4" class="form-control" required>{{ $agenda->subject }}</textarea>
                        </div>
                        
                        {{-- <div class="col-6">
                            <label for="agenda"> {{ $agenda->agenda_url ? 'Modify Agenda' : 'Upload Agenda' }}</label>
                            @if($agenda->agenda_url) 
                                <a data-id="{{ $agenda->id }}" data-attach="agenda" class="rm-b-attach text-danger float-right"> Remove Agenda </a> 
                            @endif
                            <input type="file" name="agenda" id="agenda" class="form-control">
                        </div>
                        <div class="col-6">
                            <label for="annexure">{{ $agenda->annexure_url ? 'Modify Annexure' : 'Upload Annexure' }}</label>
                            @if($agenda->annexure_url) 
                                <a data-id="{{ $agenda->id }}" data-attach="annexure" class="rm-b-attach text-danger float-right"> Remove Annexure </a> 
                            @endif
                            <input type="file" name="annexure" id="annexure" class="form-control">
                        </div>
                        <div class="col-6">
                            <label for="notesheet">{{ $agenda->notesheet_url ? 'Modify Notesheet' : 'Upload Notesheet' }}</label>
                            @if($agenda->notesheet_url) 
                                <a data-id="{{ $agenda->id }}" data-attach="notesheet" class="rm-b-attach text-danger float-right"> Remove Notesheet </a> 
                            @endif
                            <input type="file" name="notesheet" id="notesheet" class="form-control">
                        </div>
                        <div class="col-6">
                            <label for="presentation">{{ $agenda->presentation_url ? 'Modify Presentation' : 'Upload Presentation' }}</label>
                            @if($agenda->presentation_url) 
                                <a data-id="{{ $agenda->id }}" data-attach="presentation" class="rm-b-attach text-danger float-right"> Remove Presentation </a> 
                            @endif
                            <input type="file" name="presentation" id="presentation" class="form-control">
                        </div> --}}
                        @if(Auth::user()->hasRole('admin') ) {{-- && $agenda->meeting->last()->status == 'scheduled' --}}
                            <div class="col-12">
                                <a class="btn btn-primary text-white" href="/board/agenda/{{ $agenda->id }}/edit" >Edit Agenda</a>
                                <button id="rm-board-agenda" class="btn btn-outline-danger float-right" type="button">Delete Agenda</button>
                            </div>
                        @endif

                    </div>

                {{-- </form> --}}

                <form id="form-rm-agenda" action="/board/agenda/{{ $agenda->id }}" method="post">
                    @csrf
                    @method('DELETE')
                </form>

            </div>
        </div>

        <div class="card shadow-sm mt-4">
            <div class="card-header">
                PAST MEETINGS
            </div>
            <div class="card-body">
                <ul >
                    @foreach ($agenda->meeting as $meeting)
                        <li > {{ $meeting->name }} Board Meeting </li>
                    @endforeach
                </ul>
            </div>
        </div>

    </div>

@endsection