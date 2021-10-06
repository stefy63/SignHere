@extends('api.front')
@push('assets')
<link href="{{ asset('css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css') }}" rel="stylesheet">
<link href="{{ asset('font-awesome/css/font-awesome.css') }}" rel="stylesheet">
<link href="{{ asset('css/plugins/iCheck/custom.css') }}" rel="stylesheet">
<link href="{{ asset('css/jquery-ui.css') }}" rel="stylesheet">
<!-- Spinner -->
<link href="{{ asset('css/gspinner.min.css') }}" rel="stylesheet">
<style>
.digit-group input {
            width: 30px;
            height: 50px;
            /*border: 1px;*/
            line-height: 50px;
            text-align: center;
            font-size: 24px;
            font-family: 'Raleway', sans-serif;
            font-weight: bold;
            color: red;
            margin: 0 2px;
    }

    .digit-group .splitter {
            padding: 0 5px;
            font-size: 24px;
    }
</style>
@endpush
@push('scripts')
<script src="{{ asset('js/sketch.min.js') }}"></script>

<script src="{{ asset('js/plugins/iCheck/icheck.min.js') }}"></script>
<!-- Spinner -->
<script src="{{ asset('js/g-spinner.min.js') }}"></script>

<script type="text/javascript">
$(function () {

    var WizCtl ,
        pdfData = '{{$b64doc}}',
        code = '',
        $loader,
        questions = JSON.parse('{!! html_entity_decode($questions) !!}'),
        templates = JSON.parse('{!! html_entity_decode($template) !!}'),
        responseQuestions = [],
        responseTemplates = [];
        
    $('#subtitle').hide();

    $('#firma').click(function(){
        $('#Sig-Reset').show();
        resetModal(false);
        toastr['info']("{{__('sign.sign_proc_start')}}", "{{__('sign.sign_proc_start_title')}}");
        console.log('Start....');
        SendQuestionsAuthSign();
    });
    
//////////////// SIGN SCRIPT //////////////////////////

    function SendQuestionsAuthSign() {
        var page_count = $('#page_count').val();
        var content = $('<div class="i-checks"></div>');
        content.html('<label><input type="checkbox" id="chkAuth">' +
            '<i></i>&nbsp;&nbsp;&nbsp;  {!! __('sign.sign_proc_auth_question') !!} '+page_count+' page</label>');
        addElement2Modal(content);
        $('#showModal').modal();
        $('.i-checks input').iCheck({
            checkboxClass: 'icheckbox_square-green',
        });

        $('#Sig-Reset').bind('click', function(e) {
            e.stopPropagation();
            resetModal(false);
        });
        
        $('#Sig-Save').bind('click', function(e){
            e.stopPropagation();
            console.log($('#chkAuth').is(':checked'));
            if($('#chkAuth').is(':checked')) {
                resetModal(true);
                sendQuestionsSign();
            } else $('#showModal').modal('hide');
        });
    }

    function sendQuestionsSign() {
        var content = $('<div></div>');
        if (questions.length > 0 && questions[0].length > 2){
            $(questions).each(function (index) {
                console.log(questions[index]);
                var item = $('<div class="i-checks"></div>');
                item.html('<label><input type="checkbox" class="chkAuth" />' +
                    '<i></i>&nbsp;&nbsp;&nbsp;'+questions[index][5]+'</label>');
                content.append(item);
            });
            addElement2Modal(content);
            $('.i-checks input').iCheck({
                checkboxClass: 'icheckbox_square-green',
            });
            $('#Sig-Reset').bind('click', function(e) {
                e.stopPropagation();
                resetModal(false);
            });
            $('#Sig-Save').bind('click', function(e){
                e.stopPropagation();
                $('input.chkAuth').each(function (index) {
                    console.log(questions[index]);
                    if($(this).is(':checked')) {
                        responseQuestions[index] = true;
                    } else {
                        responseQuestions[index] = false;
                    }
                });
                console.log(responseQuestions);
                $('#questions').val(JSON.stringify(responseQuestions));
//                toastr['warning']("{{__('sign.sign_proc_sign_start')}}", "{{__('sign.sign_proc_start_sign_optional')}}");
                resetModal(true);
                console.log('Fine');
                sendOptionalSignSign();
            });
        } else {
//            toastr['warning']("{{__('sign.sign_proc_sign_start')}}", "{{__('sign.sign_proc_start_sign_optional')}}");
            sendOptionalSignSign();
        }
    }

    function sendOptionalSignSign() {
        console.log(templates);
        var opt = false;
        var content = $('<div></div>');
        if (templates.length > 1){
            $(templates).each(function (index) {
                if(templates[index][3].toUpperCase() == 'O'){
                    opt = true;
                    console.log(templates[index]);
                    var item = $('<div class="i-checks"></div>');
                    item.html('<label><input type="checkbox" class="chkAuth" />' +
                        '<i></i>&nbsp;&nbsp;&nbsp;'+templates[index][4]+'</label>');
                    content.append(item);
                } else {
                    console.log(templates[index]);
                    content.append('<input type="checkbox" class="chkAuth" hidden/>');
                }
            });
            if(opt == true){
                addElement2Modal(content);
                $('.i-checks input').iCheck({
                    checkboxClass: 'icheckbox_square-green',
                });
                $('#Sig-Reset').bind('click', function(e) {
                    e.stopPropagation();
                    resetModal(false);
                });
                $('#Sig-Save').bind('click', function(e){
                    e.stopPropagation();
                    $('.chkAuth').each(function (index) {
                        if($(this).is(':checked')) {
                            responseTemplates[index] = true;
                        } else {
                            responseTemplates[index] = false;
                        }
                    });
                    console.log(responseTemplates);
                    $('#templates').val(JSON.stringify(responseTemplates));
                    toastr['warning']("{{__('sign.sign_proc_sign_start_otp')}}", "{{__('sign.sign_proc_start_title')}}");
                    resetModal(true);
                    SendOTPForm();
                });
            } else {
                toastr['warning']("{{__('sign.sign_proc_sign_start_otp')}}", "{{__('sign.sign_proc_start_title')}}");
                SendOTPForm();
            }
        } else {
            toastr['warning']("{{__('sign.sign_proc_sign_start_otp')}}", "{{__('sign.sign_proc_start_title')}}");
            SendOTPForm();
        }
    }

    function SendOTPForm() {
        var content = $('<form method="get" class="digit-group text-center" data-group-name="digits" data-autosubmit="false" autocomplete="off">');
        content.append('<input type="text" id="digit-1" name="digit-1" data-next="digit-2" />');
        content.append('<input type="text" id="digit-2" name="digit-2" data-next="digit-3" data-previous="digit-1" />');
        content.append('<input type="text" id="digit-3" name="digit-3" data-next="digit-4" data-previous="digit-2" />');
        content.append('<span class="splitter">&ndash;</span>');
        content.append('<input type="text" id="digit-4" name="digit-4" data-next="digit-5" data-previous="digit-3" />');
        content.append('<input type="text" id="digit-5" name="digit-5" data-next="digit-6" data-previous="digit-4" />');
        content.append('<input type="text" id="digit-6" name="digit-6" data-previous="digit-5" />');
        content.append('</form>');
        $('#subtitle').show();
//        $('#Sig-Save').show();
        $('#Sig-Reset').hide();
        addElement2Modal(content);
        SendCode();
        $('#Sig-Save').bind('click', function(e){
            VerifyCode();
        });
        SetInputOtp();
    }
    
    function SendCode() {
//        alert('Codece inviato!');
//        return;
        var url = '{{url('api/v1/signing/send_code')}}';
        $.ajax({
            type: "GET",
            url: url,
            headers: {
                "Authorization": "Bearer {{$api_token}}"
            },
            data: {
                document_id: {{$document->id}}
            } 
        })
        .done(function(){
            toastr['success']("{{__('sign.sign_proc_sign_otp_end')}}", "{{__('sign.sign_proc_start_title')}}");
        })
        .fail(function(data) {
            code = '';
            toastr['error'](data.responseText, "{{__('sign.sign_proc_start_title')}}");
            resetModal(false);
        });
        $('#showModal').modal();
    }
    
    function VerifyCode() {
        setSpinnerOn();
        $('.digit-group').find('input').each(function() {
            code += $(this).val();
        });
        $('#showModal').modal('hide');
        
        var url = '{{url('api/v1/signing/verify_code')}}';
        $.ajax({
            type: "POST",
            url: url,
            headers: {
                "Authorization": "Bearer {{$api_token}}"
            },
            data: {
                document_id: {{$document->id}},
                code: code
            } 
        })
        .done(function(data){
            code = '';
            toastr['success']("{{__('sign.sign_proc_success')}}", "{{__('sign.sign_proc_start_title')}}");
            resetModal(false);
            $('#firma').hide();
            location.replace('{{url('api/v1/signing/show/'.$document->id)}}?api_token={{$api_token}}');
        })
        .fail(function(data) {
            code = '';
            toastr['error'](data.responseText, "{{__('sign.sign_proc_start_title')}}");
            resetModal(false);
            setSpinnerOff();
        });
    };
    
    function SetInputOtp() {
        $('.digit-group').find('input').each(function() {
            $(this).attr('maxlength', 1);
            $(this).on('keyup', function(e) {
                var parent = $($(this).parent());

                if(e.keyCode === 8 || e.keyCode === 37) {
                        var prev = parent.find('input#' + $(this).data('previous'));

                        if(prev.length) {
                                $(prev).select();
                        }
                } else if((e.keyCode >= 48 && e.keyCode <= 57) || (e.keyCode >= 65 && e.keyCode <= 90) || (e.keyCode >= 96 && e.keyCode <= 105) || e.keyCode === 39) {
                        var next = parent.find('input#' + $(this).data('next'));

                        if(next.length) {
                                $(next).select();
                        } else {
                                if(parent.data('autosubmit')) {
                                        parent.submit();
                                }
                        }
                } 
            });
        });
        $('#digit-1').focus();
    }
    
    function setSpinnerOn() {
        $('#showSpinner').modal({
            fadeDuration: 1000,
            escapeClose: false,
            clickClose: false,
            showClose: false,
            backdrop: "static"
        });
        $loader = $("#showSpinner");
        $loader.css({
            'position': 'absolute',
            'top' : '40%',
//            'left' : '0%',
            'zoom' : '1'
        });
        $loader.gSpinner();
    }
    
    function setSpinnerOff() {
        $loader.gSpinner('hide');
        $('#showSpinner').modal('hide');
    }
    
    function addElement2Modal(elem) {
        $('.modal-body').html('');
        $('.modal-body').html(elem);
        //$('#showModal').modal();
    }
    
    function resetModal(show) {
        $('#Sig-Save').unbind('click');
        $('#Sig-Reset').unbind('click');
        $('.i-checks input').iCheck('destroy');
        if (!show)
            $('#showModal').modal('hide');
        
    }

})
</script>
@endpush
@section('content')
<div class="row">
    <div class="col-lg-12 col-md-12 col-xs-12">
        <div class="ibox float-e-margins col-lg-12 col-md-12 col-xs-12">
            <div class="ibox-title col-lg-12 col-md-12 col-xs-12">
                <h5>{{__('sign.sign-pdf-title')}}: <i class="fa fa-archive"></i> {{$document->dossier->name}}: <i class="fa fa-minus-square-o" style="color: red;"></i> {{$document->name}}  <i class="fa fa-user"></i>: {{$document->dossier->client->surname.' '.$document->dossier->client->name}}</h5>
                <div ibox-tools="" class="ng-scope">
                    <div dropdown="" class="ibox-tools dropdown">
                        <button class="btn btn-primary dim" id="firma">Firma</button>
                    </div>
                </div>
            </div>
            <hr>

            <div class="">
                
                <div class="text-center" id="div-pdf-canvas" style="position: relative">
                    <pdf-viewer
                        pdfdata = '{{$b64doc}}'
                    >
                    </pdf-viewer>
                </div>

            </div>
        </div>
    </div>
</div>


<div class="modal inmodal fade" id="showModal" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="modal-title" name="name">{{__('sign.signing_document_sms_modale_title')}}</h4>
                    <span id="subtitle">{{__('sign.signing_document_sms_modale')}}</span>
                </div>
                <div class="modal-body" id="modal-body"> </div>
                <div class="modal-footer">
                    
                    <div class="row">
                        <div id="tools" class="form-group">
                            <div class="col-lg-5 col-md-5 col-xs-5 pull-left">
                                <button class="btn btn-block btn-outline btn-danger" id="Sig-Reset">Reset</button>
                            </div>
                            <div class="col-lg-2 col-md-2 col-xs-2 text-center">
                                <button class="btn btn-block btn-outline btn-warning hide" id="Sig-Clear">Clear</button>
                            </div>
                            <div class="col-lg-5 col-md-5 col-xs-5 pull-right">
                                <button class="btn btn-block btn-outline btn-primary col-md-5 pull-right" id="Sig-Save">Save</button>
                            </div>
                        </div>
                    </div>
                </div>

        </div>
    </div>
</div>
<div class="modal" id="showSpinner"></div>
@endsection
