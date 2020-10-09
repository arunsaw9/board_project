<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ mix('js/manifest.js') }}" defer></script>
    <script src="{{ mix('js/vendor.js') }}" defer></script>
    <script src="{{ mix('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">

    {{-- <script>
        var onloadCallback = function() {
            grecaptcha.render('captcha', {
                'sitekey' : '6LcgLL4UAAAAAGEfOExFvcIb-M_ZsEpyRdESmM43'
            });
        };
    </script> --}}
    {{-- <script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit"
        async defer>
    </script> --}}

    <style>
        .v-btn {
            outline: none !important;
        }

        * {
            font-size: 1rem;
        }
    </style>

</head>
<body>
    <div id="app">
        <v-app id="inspire">
            @auth
                @if( Auth::user()->hasRole('admin') ) 
                    @include('partials.navdrawer.admin')
                @elseif(Auth::user()->hasRole('user') )
                    @include('partials.navdrawer.user')
                @endif
            @endauth

            <v-app-bar
                app
                clipped-left
                @if(config('app.company') == 'ovl')
                    color="blue darken-2"
                @elseif(config('app.company') == 'opal')
                    color="red darken-2"
                @elseif(config('app.company') == 'mrpl')
                    color="lime darken-2"
                @elseif(config('app.company') == 'otpc')
                    color="orange darken-2"
                @elseif(config('app.company') == 'ompl')
                    color="green darken-2"
                @elseif(config('app.company') == 'msez')
                    color="green darken-2"
                @endif
                dark
            >
                <v-app-bar-nav-icon @click.stop="drawer.user = !drawer.user; drawer.admin = !drawer.admin "></v-app-bar-nav-icon>
                <v-img
                    class="mx-2"
                    @if(config('app.company') == 'ovl')
                        src="/img/ovl.png"
                    @elseif(config('app.company') == 'opal')
                        src="/img/opal.jpg"
                    @elseif(config('app.company') == 'mrpl')
                        src="/img/mrpl.jpg"
                    @elseif(config('app.company') == 'otpc')
                        src="/img/otpc.png"
                    @elseif(config('app.company') == 'ompl')
                        src="/img/ompl.png"
                    @elseif(config('app.company') == 'msez')
                        src="/img/msez.png"
                    @endif
                    max-height="50"
                    max-width="50"
                    contain
                ></v-img> 
                <v-toolbar-title>Board Portal</v-toolbar-title>

                <div class="flex-grow-1"></div>
                @auth
                    <v-toolbar-items>
                        <v-btn text href="/home">HOME</v-btn>
                        <v-btn text href="/user/{{ Auth::user()->id }}"> {{ Auth::user()->name }} </v-btn>
                        {{-- @if(Auth::user()->hasRole('admin'))
                            <v-btn text href="/logs" >AUDIT LOGS</v-btn>
                        @endif --}}
                        <v-btn text @click="logout()">LOGOUT</v-btn>
                    </v-toolbar-items>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                @endauth
            </v-app-bar>

            <v-content>
                @include('components.alert')
                @yield('content')
            </v-content>

        </v-app>
    </div>
</body>
</html>
