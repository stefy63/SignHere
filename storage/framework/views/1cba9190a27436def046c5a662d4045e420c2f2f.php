
<!-- Styles -->
<link href="<?php echo e(asset('css/app.css')); ?>" rel="stylesheet">
<link href="<?php echo e(asset('css/style.css')); ?>" rel="stylesheet">


<!-- Scripts -->
<script>
    window.Laravel = <?php echo json_encode([
        'csrfToken' => csrf_token(),
    ]); ?>;

    /*$(document).ready(function(){
        setTimeout( function(){
            $('#alert .alert').slideUp(2000);
        },5000 );
    });*/
</script>