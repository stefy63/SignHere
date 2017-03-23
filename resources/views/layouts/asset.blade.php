
<!-- Styles -->
<link href="{{ asset('css/app.css') }}" rel="stylesheet">
<link href="{{ asset('css/style.css') }}" rel="stylesheet">


<!-- Scripts -->
<script>
    window.Laravel = {!! json_encode([
        'csrfToken' => csrf_token(),
    ]) !!};

    /*$(document).ready(function(){
        setTimeout( function(){
            $('#alert .alert').slideUp(2000);
        },5000 );
    });*/
</script>