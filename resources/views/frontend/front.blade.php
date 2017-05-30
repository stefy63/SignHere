<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="initial-scale=1.0, width=device-height"><!--  mobile Safari, FireFox, Opera Mobile  -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sign Here</title>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

    <!-- Styles and Script -->
    @include('layouts.asset')

</head>
<body class="full-height-layout full-width white-bg" >
<div class="wrapper">
    <br>
    @if (Route::has('login'))
        <div class="links text-right">
            @if (Auth::check())
                @if(Auth::user()->isAdmin())
                    <a class="pull-left" href="{{ url('admin') }}">Admin</a>
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
        <!-- Section Container -->
        @yield('content')
    </div>
    <!--<div class="footer">
         Section Footer
        @include('layouts.footer')
    </div> -->
</div>
    <!-- Section Java Script -->
    @include('layouts.script')
</body>
</html>
