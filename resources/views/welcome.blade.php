<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>
        <script src="{{ asset('js/app.js') }}" defer></script>
        <script src="{{ asset('js/manifest.js') }}" defer></script>
        <script src="{{ asset('js/vendor.js') }}" defer></script>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <link rel="stylesheet" href="{{ asset('css/app.css') }}">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }
        </style>

        <script src="https://www.google.com/recaptcha/api.js?render=6Le5Ir4UAAAAAB-AHkL80ZncVReLvyemY7XCgYXQ"></script>
        <script>
        grecaptcha.ready(function() {
            grecaptcha.execute('6Le5Ir4UAAAAAB-AHkL80ZncVReLvyemY7XCgYXQ', {action: 'homepage'}).then(function(token) {
            
            });
        });
        </script>

    </head>
    <body>
        <div class="container">
            <form action="/" method="POST">
                <div id="html_element"></div>
            <br/>
            <button class="btn btn-primary" type="submit">Submit</button>
            </form>
        </div>
    </body>
</html>
