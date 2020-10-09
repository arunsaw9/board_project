@extends('layouts.app')

@section('content')
    
<div class="pt-8 mb-4">
    <ul class="nav nav-tabs pl-8">
        <li class="nav-item">
            <a class="nav-link @if( $tab == 1 ) active @endif" href="/board/home/1">Board Agendas</a>
        </li>
        <li class="nav-item">
            <a class="nav-link @if( $tab == 2 ) active @endif" href="/board/home/2">Committee Agendas</a>
        </li>
        <li class="nav-item">
            <a class="nav-link @if( $tab == 3 ) active @endif" href="/board/home/3">All Agendas</a>
        </li>
    </ul>

    <div class="container">
        @if( $agendas->isNotEmpty() )
        <form action="/board/meeting" method="post">
        @csrf
            @foreach ($agendas as $agenda)
                <div class="card my-2 shadow-sm">
                    <div class="card-body py-1">
                        <div class="row">
                            <div class="col-1">
                                <input type="checkbox" class="checkBox" value="{{ $agenda->id }}" name="agendas[]" >
                            </div>
                            <div class="col-8">
                                <a href="/board/agenda/{{ $agenda->id}}" >{{ $agenda->subject }}</a>
                                <a href="/board/agenda/{{ $agenda->id}}" class="badge badge-primary text-white ml-2"> {{ $agenda->uid }} </a>
                                @if($tab == 2 ) <a href="/committee/home/{{ $agenda->committee_id }}" class="badge badge-success text-white ml-2"> {{ $agenda->committee->name }}</a> @endif
                            </div>
                            <div class="col-3 text-right">
                                @if($agenda->agenda_url) <v-btn href="/board/agenda/{{$agenda->id}}/agenda/view" target="_blank" icon color="red darken-2"> <v-icon>mdi-file</v-icon></v-btn> @endif
                                @if($agenda->annexure_url) <v-btn href="/board/agenda/{{$agenda->id}}/annexure/view" target="_blank" icon color="blue" > <v-icon>mdi-alpha-a-circle</v-icon></v-btn> @endif
                                @if($agenda->presentation_url) <v-btn href="/board/agenda/{{$agenda->id}}/presentation/view" target="_blank" icon color="orange"> <v-icon>mdi-alpha-p-circle</v-icon></v-btn> @endif
                                @if($agenda->notesheet_url) <v-btn href="/board/agenda/{{$agenda->id}}/notesheet/view" target="_blank" icon color="green"> <v-icon>mdi-alpha-n-circle</v-icon></v-btn> @endif
                                @if($agenda->supplementary_url) <v-btn href="/board/agenda/{{$agenda->id}}/supplementary/view" target="_blank" icon color="green"> <v-icon>mdi-alpha-s-circle</v-icon></v-btn> @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            
            @if( $tab == 1 )
                <button formaction="/board/meeting" class="btn btn-primary">ADD TO MEETING</button>
                <button type="button" id="btn-select-all" class="btn btn-outline-primary">SELECT ALL</button>
            @elseif( $tab == 2)
                <button formaction="/committee/agenda/copy" class="btn btn-primary">COPY TO COMMITTEE</button>
                <button type="button" id="btn-select-all" class="btn btn-outline-primary">SELECT ALL</button>
            @elseif( $tab == 3)
                <div class="w-100 d-flex justify-content-center mt-4">
                    {{ $agendas->links() }}
                </div>
            @endif

        </form>
        @else 

            <div class="alert alert-success alert-dismissible fade show ma-4" role="alert">
                <strong>All clear!</strong> No more agendas left in this category.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
            </div>

        @endif
    </div>

</div>

@endsection