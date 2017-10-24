<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Sign Here</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

    <!-- Styles and Script -->
    @include('layouts.asset')

    <style>
        html, body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Raleway', sans-serif;
            font-weight: 100;
            height: 100vh;
            margin: 0;
        }

        .full-height {
            height: 100vh;
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }

        .position-ref {
            position: relative;
        }

        .top-right {
            position: absolute;
            right: 10px;
            top: 18px;
        }

        .content {
            text-align: center;
        }

        .title {
            font-size: 84px;
        }

        .links > a {
            color: #636b6f;
            padding: 0 25px;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }


    </style>
</head>
<body id="#app">
<div class="flex-center position-ref full-height">
    @if (Route::has('login'))
        <div class="top-right links">
            @if (Auth::check())
                @if(Auth::user()->isAdmin())
                    <a href="{{ url('admin') }}">Admin</a>
                @endif
                <a href="{{ url('home') }}">Home</a>
                <a href="{{ url('logout') }}">Logout</a>
            @else
                <a href="{{ url('login') }}">Login</a>
                <!--<a href="{{ url('register') }}">Register</a>-->
            @endif
        </div>
    @endif

    <div class="content">
        @yield('content')
    </div>
    <div class="footer">
        <!-- Section Footer -->
        @include('layouts.footer')
    </div>
</div>
<!-- Section Java Script -->
@include('layouts.script')
</body>
</html>
