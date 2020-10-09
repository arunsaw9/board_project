@extends('layouts.app')

@section('content')
    
    <div class="container">
        <h3> QUERIES </h3>
        <ul>
            @foreach ($queries as $query)
                <li> {{ $query->body }} - {{ $query->raisedBy->name }} </li>
            @endforeach
        </ul>
    </div>

@endsection