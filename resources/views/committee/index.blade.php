@extends('layouts.app')

@section('content')
    
    <div class="container my-4">

        <h2 class="mx-2"> All Committees </h2>
        <div class="row">
            @foreach ($meetings as $meeting)

                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-4">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title text-primary"> {{ $meeting->committee->name }} </h5>
                            <p class="card-text"> {{ $meeting->name }} {{ $meeting->committee->name }} Meeting to be held on {{ $meeting->date }} </p>
                            <a href="/committee/home/{{ $meeting->committee_id }}" class="btn btn-outline-primary">Agendas</a>
                            <a href="/committee/meeting/{{ $meeting->id }}" class="btn btn-success text-white">Meeting</a>
                        </div>
                    </div>
                </div>

                {{-- <li> 
                    {{ $meeting->committee->name }}
                    <a href="/committee/home/{{ $meeting->committee_id }}" class="btn btn-primary" > view home </a> 
                    <a href="/committee/meeting/{{ $meeting->id }}" class="btn btn-success" > view meeting </a> 
                </li> --}}
            @endforeach
        </div>

    </div>

@endsection