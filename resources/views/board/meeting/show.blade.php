@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="card shadow-sm">
            <div class="card-body">
                <h4 class="card-title text-primary">{{ $meeting->name }} Board Meeting</h4>
                <p class="card-text"> {{ $meeting->status == 'over' ? 'Held on' : 'Scheduled to be held on' }} {{ $meeting->date }} at {{ $meeting->time }} </p>

                <table class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th>UID</th>
                            <th style="width:50%">Subject</th>
                            <th>Category</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($meeting->agendas as $item)
                            <tr>
                                <td> <a href="/board/agenda/{{ $item->id }}">{{ $item->uid }}</a> </td>
                                <td> 
                                    <p class="mb-2" > {{ $item->subject }} </p>
                                    @include('partials.attachment.board')
                                </td>
                                <td> {{ $item->category }} </td>
                                <td class="{{ $item->status }}"> {{ $item->status }} </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
@endsection