
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
<!-- Dropzone -->
<link href="{{ asset('css/plugins/dropzone/basic.css') }}" rel="stylesheet">
<link href="{{ asset('css/plugins/dropzone/dropzone.css') }}" rel="stylesheet">

<link href="{{ asset('css/style.css') }}" rel="stylesheet">
<link href="{{ asset('css/signhere.css') }}" rel="stylesheet">

<!-- Switchery -->
<link href="{{ asset('css/plugins/switchery/switchery.css') }}" rel="stylesheet">

@stack('assets')

<!-- Scripts -->
<script src="{{ asset('js/app.js') }}"></script>
<script>
    window.Laravel = {!! json_encode([
        'csrfToken' => csrf_token(),
    ]) !!};

</script>