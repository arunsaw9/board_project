@extends('layouts.app')

@section('content')
    
<div class="my-4">
    <div class="container">
        <h3 class="mx-4 mb-4">  {{ $committee->name }}  </h3>
        @if( $agendas->isNotEmpty() )
        <form action="/committee/meeting" method="post">
        @csrf
            @foreach ($agendas as $agenda)
                <div class="card my-2 shadow-sm">
                    <div class="card-body py-1">
                        <div class="row">
                            <div class="col-1">
                                <input type="hidden" name="committee_id" value={{ $committee->id }}>
                                <input class="checkBox" type="checkbox" value="{{ $agenda->id }}" name="agendas[]" >
                            </div>
                            <div class="col-8">
                                <a href="/committee/agenda/{{ $agenda->id}}" >{{ $agenda->subject }}</a>
                                <span class="badge badge-primary"> {{ $agenda->uid }}</span>
                            </div>
                            <div class="col-3 text-right">
                                @if($agenda->agenda_url) <v-btn href="/committee/agenda/{{$agenda->id}}/agenda/view" target="_blank" icon color="red darken-2"> <v-icon>mdi-file</v-icon></v-btn> @endif
                                @if($agenda->annexure_url) <v-btn href="/committee/agenda/{{$agenda->id}}/annexure/view" target="_blank" icon color="blue" > <v-icon>mdi-alpha-a-circle</v-icon></v-btn> @endif
                                @if($agenda->presentation_url) <v-btn href="/committee/agenda/{{$agenda->id}}/presentation/view" target="_blank" icon color="orange"> <v-icon>mdi-alpha-p-circle</v-icon></v-btn> @endif
                                @if($agenda->notesheet_url) <v-btn href="/committee/agenda/{{$agenda->id}}/notesheet/view" target="_blank" icon color="green"> <v-icon>mdi-alpha-n-circle</v-icon></v-btn> @endif
                                @if($agenda->supplementary_url) <v-btn href="/committee/agenda/{{$agenda->id}}/supplementary/view" target="_blank" icon color="green"> <v-icon>mdi-alpha-s-circle</v-icon></v-btn> @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        
            <button formaction="/committee/meeting" class="btn btn-primary">ADD TO MEETING</button>
            <a class="btn btn-outline-primary" href="/committee/meeting/{{ $meeting->id }}">Go to Meeting</a>
            <button type="button" id="btn-select-all" class="btn btn-outline-primary float-right">SELECT ALL</button>

        </form>
        @else 

            <div class="alert alert-success alert-dismissible fade show ma-4" role="alert">
                <strong>All clear!</strong> No more agendas left in this category.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <a class="btn btn-outline-primary mx-4" href="/committee/meeting/{{ $meeting->id }}">Go to Meeting</a>

        @endif
    </div>

</div>

@endsection