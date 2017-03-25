<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Sign Here') }}</title>

    <!-- Styles and Script -->
    @include('layouts.asset')
</head>
<body>
    <div>
        <!-- Section Header -->
        <div class="row-fluid col-md-12 col-lg-12 col-sm-12 col-xs-12">
            @section('header')
                @include('layouts.header')
            @show
        </div>
        <div class="row-fluid col-md-12 col-lg-12 col-sm-12 col-xs-12">
        <!-- Section Left Menu -->
            @if(Auth::check())
                <div class="row-fluid col-md-2 col-lg-2 col-sm-2 col-xs-2" id="colsx">
                    @menu
                </div>
            @endif
            @show

        <!-- Section Right Content -->
            <div class="row-fluid col-md-10 col-lg-10 col-sm-10 col-xs-10"  id="coldx">
                <div>
                    <div  class="col-md-12" id="alert">
                        @if (Session::has('message'))
                            <div class="alert alert-info">{{ ucfirst(Session::get('message').'  '.$errors->first()) }}</div>
                            <?php Session::remove('message'); ?>
                        @endif
                        @if (Session::has('alert'))
                            <div class="alert alert-danger">{{ ucfirst(Session::get('alert').'  '.$errors->first()) }}</div>
                            <?php Session::remove('alert'); ?>
                        @endif
                        @if (Session::has('success'))
                            <div class="alert alert-success">{{ ucfirst(Session::get('success').'  '.$errors->first()) }}</div>
                            <?php Session::remove('success'); ?>
                        @endif
                    </div>
                </div>
                @yield('content')
            </div>
        </div>
        <!-- Section Footer -->
        <div>
            @include('layouts.footer')
        </div>
    </div>

    <!-- Section Java Script -->
    @include('layouts.script')
</body>
</html>
