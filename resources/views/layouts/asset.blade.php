<script>
    window.Laravel = {!! json_encode([
        'csrfToken' => csrf_token(),
    ]) !!};

</script>


<!-- Styles -->
<link href="{{ asset('css/app.css') }}" rel="stylesheet">
<!-- Styles inspinia-->

<link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
<link href="{{ asset('font-awesome/css/font-awesome.css') }}" rel="stylesheet">
<!-- Toastr style -->
<link href="{{ asset('css/plugins/toastr/toastr.min.css') }}" rel="stylesheet">
<!-- Sweet Alert -->
<link href="{{ asset('css/plugins/sweetalert/sweetalert.css') }}" rel="stylesheet">

<link href="{{ asset('css/animate.css') }}" rel="stylesheet">

<link href="{{ asset('css/style.css') }}" rel="stylesheet">
<link href="{{ asset('css/signhere.css') }}" rel="stylesheet">

<!-- Switchery -->
<link href="{{ asset('css/plugins/switchery/switchery.css') }}" rel="stylesheet">
<!-- Data picker -->
<link href="{{ asset('css/plugins/datapicker/datepicker3.css') }}" rel="stylesheet">

@stack('assets')
