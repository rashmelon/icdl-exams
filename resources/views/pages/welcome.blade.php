<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>ICDL Exams</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link rel="icon" href="{{ asset('/logo.png') }}" type="image/x-icon"/>
        <link rel="stylesheet" href="{{ asset('css/app.css') }}" type="text/css">
        <link rel="stylesheet" href="{{ asset('css/app2.css') }}" type="text/css">
        <script src="{{ asset('js/app.js') }}" async defer></script>

        <!-- Styles -->
        <style>


        </style>
    </head>
    <body>


    <div class="flex-center position-ref full-height position-relative container" id="app">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div>
            @endif

            <div class="content w-100">
                <img class="img-bg" src="{{asset('logo.png')}}">

                <div class="title m-b-md">
                    ICDL Exams
                </div>

                <div class="links menu">
                    <a href="/category">Category</a>
                    <a href="/exam">Exams</a>
                    <a href="/instruction">Instructions</a>
                    <a href="/un-assigned-candidate">Unassigned</a>
                </div>

                <reserve></reserve>

            </div>
        </div>

    </body>
</html>
