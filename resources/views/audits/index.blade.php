@extends('layouts.app')

@section('content')

    <div class="container py-4">
        <div class="my-3">
            <a href="/logs?model=boardagenda" class="btn btn-outline-primary">Board Agenda</a>
            <a href="/logs?model=boardmeeting" class="btn btn-outline-primary">Board Meeting</a>
            <a href="/logs?model=committeeagenda" class="btn btn-outline-primary">Committee Agenda</a>
            <a href="/logs?model=committeemeeting" class="btn btn-outline-primary">Committee Meeting</a>
            <a href="/logs?model=user" class="btn btn-outline-primary">User</a>
            <a href="/logs?model=notification" class="btn btn-outline-primary">Notification</a>
        </div>
        <div class="card">
            <div class="card-body">
                {{ $logs }}
            </div>
        </div>
    </div>

@endsection