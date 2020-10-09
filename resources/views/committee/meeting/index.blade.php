@extends('layouts.app')

@section('content')
    
    <div class="container mt-4">

        <div class="d-flex justify-content-center align-items-center">
            @if(config('app.company') == 'ovl')
                <img src="/img/ovl.png" width="50" height="50" alt="ovl" class="mr-4">
                <h1 class="display-3 mb-0">ONGC Videsh Limited</h1>
            @elseif(config('app.company') == 'opal')
                <img src="/img/opal.jpg" width="50" height="50" alt="ovl" class="mr-4">
                <h1 class="display-3 mb-0">ONGC Petro additions Limited</h1>
            @elseif(config('app.company') == 'mrpl')
                <h1 class="display-2 mb-0 text-center"> <span><img src="/img/mrpl.jpg" width="50" height="50" alt="MRPL" class="mr-2"></span> Mangalore Refinery & Petrochemicals Limited </h1>
            @elseif(config('app.company') == 'otpc')
                <h1 class="display-2 mb-0 text-center"> <span><img src="/img/otpc.png" width="50" height="50" alt="OTPC" class="mr-2"></span> ONGC Tripura Power Company Limited </h1>
            @elseif(config('app.company') == 'ompl')
                <h1 class="display-2 mb-0 text-center"> <span><img src="/img/ompl.png" width="50" height="50" alt="OMPL" class="mr-2"></span> ONGC Managlore Petrochemicals Limited </h1>
            @elseif(config('app.company') == 'msez')
                <h1 class="display-2 mb-0 text-center"> <span><img src="/img/msez.png" width="50" height="50" alt="OMPL" class="mr-2"></span> ONGC Managlore SEZ Limited </h1>
            @endif
        </div>

        <div class="ma-4 text-center">
            <h5 class="text-uppercase"> 
            {{ $meeting->name }}{{ ["TH","ST","ND","RD","TH","TH","TH","TH","TH","TH"][$meeting->name%10] }} Meeting of the <a href="#"> {{ $meeting->committee->name }} Meeting </a>, to be held on
            {{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $meeting->date . " " . $meeting->time )->format('l jS \\of F Y h:i A') }} 
            at {{ $meeting->place }} </h5>
            <h5 class="my-4 font-weight-bold" style="text-decoration: underline;"> CONSOLIDATED LIST OF AGENDAS </h5>
        </div>

        <div class="my-4" >
            <div class="row">
                <div class="col-12 col-sm-12 col-md-12 col-lg-7 col-xl-7">
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a class="nav-link" href="/board/meeting">Board</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle active" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Committee</a>
                            <div class="dropdown-menu" style="z-index:1">
                                @foreach(Auth::user()->committees as $option )
                                    <a class="dropdown-item @if($option->agendas->count() == 0) disabled  @endif" href="/committee/meeting/user/{{ $option->id }}"> {{ $option->name }}</a>
                                @endforeach
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="col-12 col-sm-6 col-md-6 col-lg-3 col-xl-3">
                    <form action="/committee/meeting/{{ $meeting->id }}/filter" method="post">
                    @csrf
                        <select name="category" id="category" onchange="this.form.submit()" class="form-control">
                            <option value="All" @if( $category == 'All' ) selected @endif>All ({{ $meeting->agendas->count() }} items)</option>
                            @foreach (\App\Category::all() as $option )
                                <option value="{{ $option->name }}" @if( $category == $option->name ) selected @endif>{{ $option->name }} ({{ $meeting->agendas->where('category', $option->name )->count() }} items)</option>
                            @endforeach
                        </select>
                    </form>
                </div>

                <div class="col-12 col-sm-6 col-md-6 col-lg-2 col-xl-2">
                    <form action="/committee/meeting/{{ $meeting->id }}/filter" method="post">
                    @csrf
                        <select name="date" id="date" class="form-control" onchange="this.form.submit()">
                            <option value="">CIRCULATED ON</option>
                            @foreach ($dates as $date)
                                <option value="{{ $date }}" @if( $selectedDate == $date ) selected @endif> {{ $date }} </option>
                            @endforeach
                        </select>
                    </form>
                </div>
            </div>
        </div>

        <div>
            <table class="table table-hover table-bordered">
                <thead class="bg-{{ config('app.company') }} text-white">
                    <tr>
                        <th class="text-center">AGENDA ITEM NO</th>
                        <th class="w-50 text-center">SUBJECT</th>
                        <th class="text-center">REMARKS</th>
                        <th class="text-center">CATEGORY</th>
                        <th class="text-center">BOARD REF NO</th>
                        <th class="text-center">CIRCULATED ON</th>
                    </tr>
                </thead>
                <tbody>

                    {{-- <tr style="background: #a07dde4d"><td colspan="6"> <h5> LEAVE OF ABSENCE ( {{ $leave->count() }} {{ str_plural('ITEM', $leave->count() ) }} ) </h5> </td></tr> --}}
                    {{-- <tr style="background: #d4615e75"><td colspan="6"> <h5> LEAVE OF ABSENCE ( {{ $leave->count() }} {{ str_plural('ITEM', $leave->count() ) }} ) </h5> </td></tr> --}}
                    <tr class="bg-{{ config('app.company') }}-light"><td colspan="6"> <h5> LEAVE OF ABSENCE ( {{ $leave->count() }} {{ str_plural('ITEM', $leave->count() ) }} ) </h5> </td></tr>
                    @foreach ($leave as $item)
                        <tr>
                            <td> {{ $item->uid }}</td>
                            <td> 
                                <p class="mb-2"> {{ $item->subject }} </p>
                                @include('partials.attachment.committee')
                            </td>
                            <td> {{ $item->type }}</td>
                            <td> {{ $item->category }}</td>
                            <td> {{ $item->board_uid }}</td>
                            <td> {{ $item->added_at }}</td>
                        </tr>
                    @endforeach

                    {{-- <tr style="background: #a07dde4d"><td colspan="6"> <h5> MINUTES ( {{ $minutes->count() }} {{ str_plural('ITEM', $minutes->count() ) }} ) </h5> </td></tr> --}}
                    {{-- <tr style="background: #d4615e75"><td colspan="6"> <h5> MINUTES ( {{ $minutes->count() }} {{ str_plural('ITEM', $minutes->count() ) }} ) </h5> </td></tr> --}}
                    <tr class="bg-{{ config('app.company') }}-light"><td colspan="6"> <h5> MINUTES ( {{ $minutes->count() }} {{ str_plural('ITEM', $minutes->count() ) }} ) </h5> </td></tr>
                    @foreach ($minutes as $item)
                        <tr>
                            <td> {{ $item->uid }}</td>
                            <td> 
                                <p class="mb-2"> {{ $item->subject }} </p>
                                @include('partials.attachment.committee')
                            </td>
                            <td> Noting </td>
                            <td> {{ $item->category }} </td>
                            <td> {{ $item->board_uid }}</td>
                            <td> {{ $item->added_at }}</td>
                        </tr>
                    @endforeach

                    {{-- <tr style="background: #a07dde4d"><td colspan="6"> <h5> APPROVAL ( {{ $approval->count() }} {{ str_plural('ITEM', $approval->count() ) }} )</h5> </td></tr> --}}
                    {{-- <tr style="background: #d4615e75"><td colspan="6"> <h5> APPROVAL ( {{ $approval->count() }} {{ str_plural('ITEM', $approval->count() ) }} )</h5> </td></tr> --}}
                    <tr class="bg-{{ config('app.company') }}-light"><td colspan="6"> <h5> APPROVAL ( {{ $approval->count() }} {{ str_plural('ITEM', $approval->count() ) }} )</h5> </td></tr>
                    @foreach ($approval as $item)
                        <tr>
                            <td> {{ $item->uid }}</td>
                            <td> 
                                <p class="mb-2"> {{ $item->subject }} </p>
                                @include('partials.attachment.committee')
                            </td>
                            <td> {{ $item->type }}</td>
                            <td> {{ $item->category }}</td>
                            <td> {{ $item->board_uid }}</td>
                            <td> {{ $item->added_at }}</td>
                        </tr>
                    @endforeach

                    {{-- <tr style="background: #a07dde4d"><td colspan="6"> <h5> INFORMATION ( {{ $information->count() }} {{ str_plural('ITEM', $information->count() ) }} ) </h5> </td></tr> --}}
                    {{-- <tr style="background: #d4615e75"><td colspan="6"> <h5> INFORMATION ( {{ $information->count() }} {{ str_plural('ITEM', $information->count() ) }} ) </h5> </td></tr> --}}
                    <tr class="bg-{{ config('app.company') }}-light"><td colspan="6"> <h5> INFORMATION ( {{ $information->count() }} {{ str_plural('ITEM', $information->count() ) }} ) </h5> </td></tr>
                    @foreach ($information as $item)
                        <tr>
                            <td> {{ $item->uid }}</td>
                            <td> 
                                <p class="mb-2"> {{ $item->subject }} </p>
                                @include('partials.attachment.committee')
                            </td>
                            <td> {{ $item->type }}</td>
                            <td> {{ $item->category }}</td>
                            <td> {{ $item->board_uid }}</td>
                            <td> {{ $item->added_at }}</td>
                        </tr>
                    @endforeach

                    {{-- <tr style="background: #a07dde4d"><td colspan="6"> <h5> GRANTING ( {{ $granting->count() }} {{ str_plural('ITEM', $granting->count() ) }} ) </h5> </td></tr> --}}
                    {{-- <tr style="background: #d4615e75"><td colspan="6"> <h5> NOTING ( {{ $noting->count() }} {{ str_plural('ITEM', $noting->count() ) }} ) </h5> </td></tr> --}}
                    <tr class="bg-{{ config('app.company') }}-light"><td colspan="6"> <h5> NOTING ( {{ $grantingOrNoting->count() }} {{ str_plural('ITEM', $grantingOrNoting->count() ) }} ) </h5> </td></tr>
                    @foreach ($grantingOrNoting as $item)
                        <tr>
                            <td> {{ $item->uid }}</td>
                            <td> 
                                <p class="mb-2"> {{ $item->subject }} </p>
                                @include('partials.attachment.committee')
                            </td>
                            <td> {{ $item->type }}</td>
                            <td> {{ $item->category }}</td>
                            <td> {{ $item->board_uid }}</td>
                            <td> {{ $item->added_at }}</td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>

    {{-- QUERY MODAL --}}
    <div class="modal fade" id="queryModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Raise Query</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="/query" method="post">
            @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <label for="body">Query Matter</label>
                            <textarea id="body" name="body" rows="3" class="form-control" required></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Send Query</button>
                </div>
            </form>
            </div>
        </div>
    </div>

@endsection