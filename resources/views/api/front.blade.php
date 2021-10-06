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
<body class="full-height-layout full-width white-bg">
<div class="wrapper" id="app">
    <div class="content col-lg-12 col-md-12 col-xs-12">
        <!-- Section Container -->
        @yield('content')
    </div>
    <div class="footer fixed">
         <!-- Section Footer-->
        @include('layouts.footer')
    </div>
</div>

    <!-- Section Java Script -->
    @include('layouts.script')

</body>
</html>
