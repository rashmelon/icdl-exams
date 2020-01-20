<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/app2.css') }}" type="text/css">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="{{ asset('js/app.js') }}" async defer></script>


    <title>@yield('title') {{ config('app.name', 'ICDL Tests') }}</title>
    <style>
        .floating-home-btn{
            position: fixed;
            bottom: 35px;
            right: 35px;
            width: 70px;
            height: 70px;
            line-height: 60px;
            font-size: 40px;
            border-radius: 50%;
            cursor: pointer;
            z-index: 99;
            background: rgba(255,255,255,0.6);
        }

        .floating-home-btn i{
            padding-top: 7px;
        }

        .floating-home-btn.print i{
            padding-top: 0;
        }

        .floating-home-btn:hover i{
            color: white!important;
        }

        /* override styles when printing */
        @media print {
            .floating-home-btn{
                display: none;
            }
            body {
                margin: 0;
                color: #000;
                background-color: #fff;
            }

        }
        .print{
            top: 35px;
        }
    </style>
</head>
<body>


<a class="floating-home-btn btn btn-outline-primary" href="/">
    <i class="fa fa-home text-primary" aria-hidden="true"></i>
</a>

<div id="app" class="position-relative">
    @yield('content')
</div>
</body>
</html>
