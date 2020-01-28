<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{ asset('/logo.png') }}" type="image/x-icon"/>
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
            nav,
            .print,
            .options,
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
            top: 135px;
        }

        #app{
            margin-top: 70px;
        }

        .options-btn {
            bottom: 120px;
            width: 40px;
            height: 40px;
            line-height: 40px;
        }
        .options-btn i{
            font-size: 25px;
            padding: 0;
            transition: all 0.3s ease-in-out;
        }
        .options-btn:hover>i{
            transform: rotate(135deg);
        }
        .options-btn .options{
            position: absolute;
            bottom: 0;
            left: 0;
            padding-bottom: 50px;
        }
        .options .btn{
            left: 100px;
            transition: 0.1s ease-in-out;
        }
        .options-btn:hover .btn{
            left: 0;
        }
        .options-btn:hover .btn:nth-of-type(1){transition-delay: 0.500s;}
        .options-btn:hover .btn:nth-of-type(2){transition-delay: 0.3752s;}
        .options-btn:hover .btn:nth-of-type(3){transition-delay: 0.250s;}
        .options-btn:hover .btn:nth-of-type(4){transition-delay: 0.125s;}

        .options .btn{
            margin-top: 15px;
            padding: 9px;
            width: 35px;
            height: 35px;
            line-height: 35px;
            text-align: center;
            position: relative;
        }
        .options i{
            font-size: 14px;

        }
        .options .popper:after{
            content: '';
            position: absolute;
            top: 30%;
            right: -15px;
            border: 7px solid transparent;
            border-bottom-color: #333;
            transform: rotate(90deg);
        }

        .options .popper{
            position: absolute;
            right: 50px;
            top: 0;
            background: rgba(255,255,255,0.8);
            padding: 0 10px;
            border-radius: 7px;
            color: #000;
            display: none;
            width: max-content;
            border: 1px solid #333;
        }
        .options .btn:hover .popper{
            display: block;
        }

    </style>
</head>
<body>


<a class="floating-home-btn btn btn-outline-primary" href="/">
    <i class="fa fa-home text-primary" aria-hidden="true"></i>
</a>


<div class="floating-home-btn options-btn btn btn-outline-success">
    <span class="btn success-btn p-0 text-center d-block">
        <i class="fa fa-cog text-success d-flex justify-content-center align-items-center" aria-hidden="true"></i>
    </span>

    <div class="options">
        <div class="btn btn-info rounded-circle">
            <a href="/category">
                <i class="fa fa-bookmark" aria-hidden="true"></i>
                <span class="popper">Category</span>
            </a>
        </div>
        <div class="btn btn-info rounded-circle">
            <a href="/exam">
                <i class="fa fa-address-book" aria-hidden="true"></i>
                <span class="popper">Exam</span>
            </a>
        </div>
        <div class="btn btn-info rounded-circle">
            <a href="/instruction">
                <i class="fa fa-database" aria-hidden="true"></i>
                <span class="popper">Instruction</span>
            </a>
        </div>
        <div class="btn btn-info rounded-circle">
            <a href="/un-assigned-candidate">
                <i class="fa fa-child" aria-hidden="true"></i>
                <span class="popper">Unassigned Candidate</span>
            </a>
        </div>
    </div>
</div>
@include('partials.header')
<div id="app" class="position-relative">
    @yield('content')
</div>
</body>
</html>
