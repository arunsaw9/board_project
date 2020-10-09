@extends('layouts.app')

@section('content')
    
    <div class="container">

        <div class="row">
            @foreach ($users as $user)
            <div class="col-4">
                <div class="card w-100">
                    <div class="card-body d-flex">
                        <img style="border-radius:50%" width="50px" height="50px" src="https://ui-avatars.com/api/?name={{ $user->name }}" alt="Avatar">
                        <div class="ml-4">
                            <a href="/user/{{ $user->id }}" class="card-title mb-1">{{ $user->name }} </a>
                            <p class="card-text font-weight-bold mb-0"> {{ $user->role }} </p>
                            <p class="card-text">{{ $user->email }}</p>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
    </div>

@endsection