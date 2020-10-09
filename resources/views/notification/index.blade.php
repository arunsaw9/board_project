@extends('layouts.app')

@section('content')

<div class="container mt-2">

    @if($notifications->isNotEmpty())
        {{-- <div class="row">
            @foreach ($notifications as $item )
                <div class="col-6 col-sm-6 col-md-4 col-lg-4 col-xl-4">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-text"> {{ $item->title }} </h5>
                            @if( Auth::user()->hasRole('admin') )
                                <form action="/notification/{{ $item->id }}" method="post">
                                @csrf 
                                @method('DELETE')
                                    <a href="/notification/{{ $item->id }}" class="btn btn-sm btn-outline-primary">Modify</a>
                                    <button class="btn btn-sm btn-outline-danger">Delete </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div> --}}
        <table class="table shadow">
            <thead>
                <tr>
                    <th>#</th>
                    <th class="w-75">Notification</th>
                    @if(Auth::user()->hasRole('admin'))
                    <th>Action</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach ($notifications as $key => $n)
                    <tr>
                        <td> {{ $key +1 }}</td>
                        <td> {{ $n->title }} </td>
                        @if(Auth::user()->hasRole('admin'))
                        <td>
                            <form action="/notification/{{ $n->id }}" method="post">
                            @csrf 
                            @method('DELETE')
                                <a href="/notification/{{ $n->id }}" class="btn btn-sm btn-outline-primary">View</a>
                               
                                    <button class="btn btn-sm btn-outline-danger">Delete </button>
                                
                            </form>
                        </td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else 
        <div class="alert alert-info">
            No new notifications
        </div>
    @endif
</div>

@endsection