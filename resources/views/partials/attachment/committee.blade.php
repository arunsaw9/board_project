@if($item->agenda_url) 
    <a href="/committee/agenda/{{ $item->id }}/agenda/view" class="btn btn-sm btn-outline-primary" target="_blank" >Agenda</a> 
@else
    <a href="#" class="btn btn-sm btn-light disabled">Agenda</a>
@endif
@if($item->annexure_url) 
    <a href="/committee/agenda/{{ $item->id }}/annexure/view" class="btn btn-sm btn-outline-primary" target="_blank">Annexure</a> 
@else 
    <a href="#" class="btn btn-sm btn-light disabled">Annexure</a>
@endif
@if($item->presentation_url) 
    <a href="/committee/agenda/{{ $item->id }}/presentation/view" class="btn btn-sm btn-outline-primary" target="_blank">Presentation</a>
@else 
    <a href="#" class="btn btn-sm btn-light disabled">Presentation</a>
@endif

@if($item->supplementary_url) 
    <a href="/committee/agenda/{{ $item->id }}/supplementary/view" class="btn btn-sm btn-outline-primary" target="_blank">Supplementary</a>
@endif

@if( Auth::user()->hasRole('admin') )
    @if($item->notesheet_url) 
        <a href="/committee/agenda/{{ $item->id }}/notesheet/view" class="btn btn-sm btn-outline-primary" target="_blank">Notesheet</a>
    @else 
        <a href="#" class="btn btn-sm btn-light disabled">Notesheet</a>
    @endif
@endif

@if($item->status == 'takenup') 
    <button class="btn btn-sm btn-outline-secondary" data-toggle="modal" data-target="#queryModal">Raise Query</button>
@endif