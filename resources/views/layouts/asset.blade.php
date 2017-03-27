
<!-- Styles -->
<link href="{{ asset('css/app.css') }}" rel="stylesheet">

<!-- Styles inspinia-->

    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('font-awesome/css/font-awesome.css') }}" rel="stylesheet">

    <link href="{{ asset('css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/signhere.css') }}" rel="stylesheet">

<!-- Scripts -->
<script src="{{ asset('js/app.js') }}"></script>
<script>
    window.Laravel = {!! json_encode([
        'csrfToken' => csrf_token(),
    ]) !!};

    $(document).ready(function(){
        setTimeout( function(){
            $('#alert .alert').slideUp(2000);
        },5000 );
    });
</script>