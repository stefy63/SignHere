<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Sign Here') }}</title>

    <!-- Styles and Script -->
    @include('layouts.asset')

</head>

<body >
    <div id="wrapper" >
 <!-- <a href="https://www.google.it"  onclick="window.open('print.html', 'newwindow', 'width=300,height=250'); return false;"> Print</a>-->
        @if(Auth::check())
            <!-- Section menu -->
            @include('admin.menu')
        @endif

        <div id="page-wrapper" class="white-bg" style="min-height: 490px;">
            <div class="page-heading">
                <!-- Section header -->
                @include('layouts.header')
            </div>
            <div class="row wrapper wrapper-content animated fadeInRight" id="app">
                @yield('content')
            </div>
            <div class="footer fixed">
                <!-- Section Footer -->
                @include('layouts.footer')
            </div>
        </div>
    </div>
<!-- Section Java Script -->
@include('layouts.script')

</body>

</html>
