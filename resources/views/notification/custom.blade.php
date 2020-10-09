@extends('layouts.app')

@section('content')

<div class="container mt-2">
    <div class="card shadow-sm">
        <div class="card-body">
            <h3 class="card-title text-primary"> <v-icon color="primary">mdi-pencil-outline</v-icon> Create Custom Notification</h3>

            <form action="/notification" method="post" >
            @csrf
                <div class="row">
                    <div class="col-12">
                        @foreach (\App\User::all() as $user)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="users[]" id="{{ $user->id }}" value="{{ $user->id }}">
                                <label class="form-check-label" for="{{ $user->id }}">{{ $user->name }}</label>
                              </div>
                        @endforeach
                    </div>
                    <div class="col-12">
                        <label for="title">Notification Body</label>
                        <textarea name="title" id="title" rows="4" class="form-control"></textarea>
                        <small class="mt-3"><span id="char-count">0</span>/320 characters</small>
                    </div>
                    <div class="col-12">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="save" id="save" >
                            <label class="form-check-label" for="save">Add notification to home page?</label>
                        </div>
                    </div>
                    <div class="col-12">
                        <button class="btn btn-primary">Create</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection