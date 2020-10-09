@extends('layouts.app')

@section('content')
    
    <div class="container">
        <div class="row">
            @foreach ($meetings as $meeting)
                <div class="col-4">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title"> {{ $meeting->name }} {{ $meeting->committee->name }} Meeting </h4>
                            <p class="card-text"> {{ $meeting->date }} </p>
                        </div>
                        <div class="card-footer">
                            {{ $meeting->status }} 
                            <a href="/archive/{{ $meeting->id }}" class="float-right">View</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{ $meetings->links() }}

    </div>

@endsection