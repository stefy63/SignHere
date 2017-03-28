

<!-- Mainly scripts -->
<script src="{{ asset('js/jquery-2.1.1.js') }}"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
<script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

<!-- Custom and plugin javascript -->
<script src="{{ asset('js/inspinia.js') }}"></script>
<script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>
<!-- Toastr script -->
<script src="{{ asset('js/plugins/toastr/toastr.min.js') }}"></script>
<!-- Sweet alert -->
<script src="{{ asset('js/plugins/sweetalert/sweetalert.min.js') }}"></script>



<script>
$(function () {

    toastr.options = {
        "closeButton": true,
        "debug": false,
        "progressBar": true,
        "preventDuplicates": true,
        "positionClass": "toast-top-right",
        "onclick": null,
        "showDuration": "400",
        "hideDuration": "1000",
        "timeOut": "7000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }

    @if (session('message'))
        toastr['info']("{{ session('message') }}", "{{__('app.notify_message')}}");
    @elseif(session('alert'))
        toastr['error']("{{ session('alert') }}", "{{__('app.notify_alert')}}");
    @elseif(session('success'))
        toastr['success']("{{ session('success') }}", "{{__('app.notify_success')}}");
    @elseif(session('warning'))
        toastr['warning']("{{ session('warning') }}", "{{__('app.notify_warning')}}");
    @endif


    $('.confirm-toast').click(function () {
        var location =  this.getAttribute('data-location');
        swal({
            title: '{{__('app.confirm-title')}}',
            text: this.getAttribute('data-message'),
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes",
            closeOnConfirm: true
        }, function () {
            //$(location).prop('href',location);
            window.location.replace(location)
        });
    });

    $('.submit-toast').submit(function (e) {
        var options = options || {};
        if ( !options.lots_of_stuff_done ) {
            e.preventDefault();
            var location = this.getAttribute('action');
            swal({
                title: '{{__('app.confirm-title')}}',
                text: this.getAttribute('data-message'),
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes",
                closeOnConfirm: true
            }, function () {

                //alert(location);
                //e.complete();
            });
        } else {
            this.submit();
        }
    });



})
</script>