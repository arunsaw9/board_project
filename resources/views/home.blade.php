@extends('layouts.app')

@section('content')

    {{-- <a href="/board/home" class="btn btn-primary text-white">Board</a>
    <a href="/committee/home" class="btn btn-primary text-white">Committee</a>
    <a href="/agm/home" class="btn btn-primary text-white">AGM</a>
    <a href="/egm/home" class="btn btn-primary text-white">EGM</a> --}}

    <v-container fluid class="grey lighten-5">

        <div class="row">
            <div class="col-12">
                <a href="/board/meeting">
                    @if(config('app.company') == 'ovl')
                        <div class="card" style="min-height: 240px; background:linear-gradient(135deg, #5b247a 0%,#1bcedf 100%); color: white;">
                    @elseif(config('app.company') == 'opal')
                        <div class="card" style="min-height: 240px; background: linear-gradient(to bottom left, #ed213a, #93291e); color: white;">
                    @elseif(config('app.company') == 'mrpl')
                        <div class="card" style="min-height: 240px; background: linear-gradient(to right, #11998e, #38ef7d); color: white;">
                    @elseif(config('app.company') == 'otpc')
                            <div class="card" style="min-height: 240px; background: linear-gradient(to right, #d1913c, #ffd194); color: white;">
                    @elseif(config('app.company') == 'ompl')
                        <div class="card" style="min-height: 240px; background: linear-gradient(to right, #11998e, #38ef7d); color: white;">
                    @elseif(config('app.company') == 'msez')
                        <div class="card" style="min-height: 240px; background: linear-gradient(to right, #11998e, #38ef7d); color: white;">
                    @endif
                        <div class="card-body">
                            <h4> <v-icon color="white">mdi-account-group</v-icon> Meetings of </h4>
                            <h2 class="card-title pt-4">Board &</h2>
                            <h2>Board Level Committee(s)</h2>
                            @if($meeting->date)
                                <p class="pt-4" style="font-size:1rem"> Next Board Meeting scheduled on {{ \Carbon\Carbon::createFromFormat('Y-m-d', $meeting->date)->toFormattedDateString() }} </p>
                            @endif
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-6" style="max-height: 75vh; overflow-y:scroll">
                <div class="card">
                    @if(config('app.company') == 'ovl')
                        <div class="card-body" style="min-height: 400px; background: linear-gradient(135deg, #2980b9, #6dd5fa, #ffffff); color: white;">
                    @elseif(config('app.company') == 'opal')
                        <div class="card-body" style="min-height: 400px; background: linear-gradient(to top left, #009fff,  #ec2f4b 50%); color: white;">
                    @elseif(config('app.company') == 'mrpl')
                        <div class="card-body" style="min-height: 400px; background: linear-gradient(to right, #67b26f, #4ca2cd); color: white;">
                    @elseif(config('app.company') == 'otpc')
                        {{-- <div class="card-body" style="min-height: 400px; background: linear-gradient(to right, #f46b45, #eea849); color: white;"> --}}
                        <div class="card-body" style="min-height: 400px; background: linear-gradient(to right, #f46b45, #eea849); color: white;">
                    @elseif(config('app.company') == 'ompl')
                        <div class="card-body" style="min-height: 400px; background: linear-gradient(to right, #348f50, #56b4d3); color: white;">
                    @elseif(config('app.company') == 'msez')
                        <div class="card-body" style="min-height: 400px; background: linear-gradient(to right, #348f50, #56b4d3); color: white;">
                    @endif
                        <h4 class="mb-4" > <v-icon color="white">mdi-bell</v-icon> Notifications </h4>
                        @if($notifications->isNotEmpty())
                            <ul class="list-group pa-0" style="color:darkslategrey">
                                @foreach ($notifications as $notification)
                                    <li class="list-group-item my-1"> 
                                    <h6 style="font-size: 1rem"> {{ $notification-> title }} 
                                        <small class="text-muted float-right mt-4"> - {{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $notification->created_at)->toDateString() }} </small>
                                    </h6> 
                                </li>
                                @endforeach
                            </ul>
                        @else 
                            <h5> No new notifications ! </h5>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="card">
                    <div class="card-body p-2">
                        <div id="calendar"></div>
                    </div>
                </div>
            </div>
        </div>

        {{-- <v-row
            class="mb-6"
            justify="center"
            align="start"
        >

        <v-col cols="12" sm="12" md="6" lg="6" xl="6" >
            <v-card
                class="pa-2"
                style="background: linear-gradient(to right, #00b4db, #0083b0);"
                dark
            >
                <v-card-title>{{ $meeting->name }} Board Meeting </v-card-title>
                <v-card-text> Scheduled to be held on {{ \Carbon\Carbon::createFromFormat('Y-m-d H:i', $meeting->date . " " . $meeting->time )->format('l jS \\of F Y h:i A') }}  </v-card-text>
        
                <v-card-actions>
                    @if( Auth::user()->role == 'admin' )
                        <v-btn text href="/board/home" >View Now</v-btn>
                    @else 
                        <v-btn text href="/board/meeting" >View Now</v-btn>
                    @endif
                </v-card-actions>

            </v-card>
        </v-col>

        @foreach ($options as $option)
            <v-col cols="12" sm="12" md="6" lg="6" xl="6" >
                <v-card
                    class="pa-2"
                    style="{{ $option['style'] }}"
                    dark
                >
                    <v-card-title>{{ $option['title'] }} </v-card-title>
                    <v-card-text> {{ $option['description'] }} </v-card-text>
            
                    <v-card-actions>
                        @if( Auth::user()->role == 'admin' )
                            <v-btn text href="/board/home" >View Now</v-btn>
                        @else 
                            <v-btn text href="/board/meeting" >View Now</v-btn>
                        @endif
                    </v-card-actions>

                </v-card>
            </v-col>
        @endforeach

        <v-col cols="6">
            <div id="calendar"></div>
        </v-col>

        <v-col cols="6">
            <v-card
                class="pa-2"
                style="background: linear-gradient(135deg, #65799b 0%,#5e2563 100%)"
                dark
            >
                <v-card-title> Notifications  </v-card-title>
                <v-card-text> No new notifications </v-card-text>
        
                <v-card-actions>
                    <v-btn text href="/board/home" >View All</v-btn>
                </v-card-actions>

            </v-card>
        </v-col>

        </v-row> --}}
        
    </v-container>

@endsection
