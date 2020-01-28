<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{ asset('/logo.png') }}" type="image/x-icon"/>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/pdf.css') }}" type="text/css">
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
    </style>
<body>
    <div id="app">
        @yield('content')
    </div>
</body>
</html>
