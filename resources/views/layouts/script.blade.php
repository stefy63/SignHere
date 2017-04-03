

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
<!-- Switchery -->
<script src="{{ asset('js/plugins/switchery/switchery.js') }}"></script>



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

    $('.submit-toast').click(function (e) {
        e.preventDefault();

        var form = '#'+this.getAttribute('data-form-id');
        swal({
            title: '{{__('app.confirm-title')}}',
            text: this.getAttribute('data-message'),
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes",
            closeOnConfirm: true
        }, function () {
            $(form).submit();
        });
    });


    var defaults = {
        color             : '#1AB394',
        secondaryColor    : '#dfdfdf',
        jackColor         : '#ED5565',
        jackSecondaryColor: '#dfdfdf',
        className         : 'switchery',
        disabled          : false,
        disabledOpacity   : 0.5,
        speed             : '0.5s',
        size              : 'small'
    }

    var elem = document.querySelector('.js-switch');
    var switchery = new Switchery(elem,defaults);


    @if(count($errors) > 0)
        toastr['error']("{{__('app.notify_alert_field')}}", "{{__('app.notify_alert')}}");
        var jCampi = [@foreach($errors->keys() as $k => $info)
            '{{ $info }}',
            @endforeach ];
        for (var key in jCampi) {
            $('label[for="'+jCampi[key]+'"]').css('color','red');
        };
    @endif

})
</script>