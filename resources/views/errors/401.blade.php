<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Sign Here | 400 Error</title>

    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('font-awesome/css/font-awesome.css') }}" rel="stylesheet">
    <link href="{{ asset('css/animate.css') }}" rel="stylesheet"
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

</head>

<body class="gray-bg">


    <div class="middle-box text-center animated fadeInDown">
        <h1>{{ $exception->getStatusCode() }}</h1>
        <h3 class="font-bold">Internal Server Error</h3>

        <div class="error-desc">
            <p></p>
            <p><h1>{{ $exception->getMessage() }}</h1></p>
        </div>
    </div>

    <!-- Mainly scripts -->
<script src="{{ asset('js/jquery-2.1.1.js') }}"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>

</body>

</html>
