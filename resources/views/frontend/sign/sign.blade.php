@extends('frontend.front')
@push('assets')
<link href="{{ asset('css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css') }}" rel="stylesheet">
<link href="{{ asset('font-awesome/css/font-awesome.css') }}" rel="stylesheet">
<link href="{{ asset('css/plugins/iCheck/custom.css') }}" rel="stylesheet">

<style>
#signature{
    width: 100%;
    height: 100%;
    border: 1px solid black;
    color: blue;
    background-color:lightgrey;
    z-index: -1;
}
</style>
@endpush
@push('scripts')
<script src="{{ asset('js/jSignature/libs/jSignature.min.js') }}"></script>
<!--<script src="{{ asset('js/jSignature/libs/modernizr.js') }}"></script>-->
<!--[if lt IE 9]>
<script src="{{ asset('js/jSignature/libs/flashcanvas.js') }}"></script>
<![endif]-->


<script src="{{ asset('js/pdf.js') }}"></script>
<script src="{{ asset('js/compatibility.js') }}"></script>
<!-- iCheck -->
<script src="{{ asset('js/plugins/iCheck/icheck.min.js') }}"></script>

<script type="text/javascript">
$(function () {

    var pdfData = atob("{{$b64doc}}");

    var WizCtl ,
        lic,
        Licence,
        hash,
        ctlScript = 0,
        questions = JSON.parse('{!! html_entity_decode($questions) !!}'),
        templates = JSON.parse('{!! html_entity_decode($template) !!}'),
        responseQuestions = [],
        responseTemplates = [],
        Pad,
        StepHandler,
        WacomCtl,
        $sigdiv = false;

    print(questions);


    $('#start').click(function () {
        toastr['info']("{{__('sign.sign_proc_start')}}", "{{__('sign.sign_proc_start_title')}}");
        if(WacomCtl) {
            fPad();
            SendQuestionsAuth();
        } else {
            SendQuestionsAuthSign();
        }
    });

    $('#about').click(function () {
        if(WacomCtl)
            AboutBox();
    })

//////////////// SIGN SCRIPT //////////////////////////

    function SendQuestionsAuthSign() {
        var content = $('<div class="i-checks"></div>');
        content.html('<label><input type="checkbox" id="chkAuth">' +
            '<i></i>&nbsp;&nbsp;&nbsp;  {!! __('sign.sign_proc_auth_question') !!}'+pdfDoc.numPages+'</label>');

        addElement2Modal(content);
        $('#showModal').modal();
        $('.i-checks input').iCheck({
            checkboxClass: 'icheckbox_square-green',
        });
        $('.i-checks input').on('ifChecked ifUnchecked', function(event) {
            console.log(event.type);
            if (event.type == 'ifChecked') {
                $('#chkAuth').prop("checked",true);
            } else {
                $('#chkAuth').prop("checked",false);
            }
        });
        //// event click ////
        $('#Sig-Reset').bind('click', function(e) {
            e.stopPropagation();
            $('#showModal').modal('hide');
        });
        $('#Sig-Save').bind('click', function(e){
            e.stopPropagation();
            console.log($('#chkAuth').is(':checked'));
            if($('#chkAuth').is(':checked')) {
                //$('#showModal').modal('hide');
                $('#Sig-Save').unbind('click');
                $('.i-checks input').iCheck('destroy');
                sendQuestionsSign();
            } else $('#showModal').modal('hide');
        });
    }

    function sendQuestionsSign() {
        console.log(questions);
        var content = $('<div></div>');
        if (questions.length > 1){
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
                $('#showModal').modal('hide');
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
                toastr['warning']("{{__('sign.sign_proc_sign_start')}}", "{{__('sign.sign_proc_start_sign_optional')}}");
                //$('#showModal').modal('toggle');
                $('#Sig-Save').unbind('click');
                $('.i-checks input').iCheck('destroy');
                console.log('Fine');
                sendOptionalSignSign();
            });
        } else {
            toastr['warning']("{{__('sign.sign_proc_sign_start')}}", "{{__('sign.sign_proc_start_sign_optional')}}");
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
                    $('#showModal').modal('hide');
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
                    toastr['warning']("{{__('sign.sign_proc_sign_start')}}", "{{__('sign.sign_proc_start_title')}}");
                    //$('#showModal').modal('hide');
                    $('#Sig-Reset').unbind('click');
                    $('#Sig-Save').unbind('click');
                    $('.i-checks input').iCheck('destroy');
                    CaptureSign();
                });
            } else {
                toastr['warning']("{{__('sign.sign_proc_sign_start')}}", "{{__('sign.sign_proc_start_title')}}");
                CaptureSign();
            }
        } else {
            toastr['warning']("{{__('sign.sign_proc_sign_start')}}", "{{__('sign.sign_proc_start_title')}}");
            CaptureSign();
        }
    }

    function CaptureSign() {
        var content = $('<div id="signature"></div>');
        addElement2Modal(content);
        $sigdiv = $("#signature").jSignature({'UndoButton':false});
        $sigdiv.jSignature("reset");
        var imgSrcData;
        $('#Sig-Reset').bind('click', function(e) {
            e.stopPropagation();
            $sigdiv.jSignature('reset');
        });
        $('#Sig-Save').bind('click', function(e){
            e.stopPropagation();
            imgSrcData = 'data:'+$sigdiv.jSignature('getData', 'image');
            $('#b64image').attr("src",imgSrcData);
            $("#imgB64").val(imgSrcData);
            console.log(imgSrcData);
            $('#Sig-Reset').unbind('click');
            $('#Sig-Save').unbind('click');
            $('#showModal').modal('hide');
        });
        $('#signature canvas').css('height','100%');

    }




    function addElement2Modal(elem) {
        $('.modal-body').html('');
        $('.modal-body').html(elem);
        //$('#showModal').modal();
    }

//////////////// WACOM SCRIPT //////////////////////////
    function escapeHtml(unsafe) {
        return unsafe
            .replace(/&amp;/g, "&")
            .replace(/&lt;/g, "<")
            .replace(/&gt;/g, ">")
            .replace(/&quot;/g, "\"")
            .replace(/&#039;/g, "'");
    }
    // Wizard control enum values
    var WizObject = {
        Text:0,
        Button:1,
        Checkbox:2,
        Signature:3,
        ObjectHash:6
    };

    // Wizard control enum values
    var WizCheckboxOptions = {
        Checked:0,
        DisplayCross:1,
        DisplayTick:2,
        Unchecked:3
    };

    function fPad() {
        WizCtl.SetProperty("Licence",Licence);
        var wc = WizCtl.PadConnect();
        if( wc != true ) {
            print("Unable to make connection to the Pad");
            WizCtl.Reset();
        }
        else {
            var zoom=50; // set default
            print("Pad detected: " + WizCtl.PadWidth + " x " + WizCtl.PadHeight);

            switch (WizCtl.PadWidth) {
                case 396:    Pad = new TPad("STU-300", 60, 200, 200, 8, 8, 16, 70, 100, 200, 35, 30, 10);
                    zoom = 100;
                    break;
                case 640:    Pad = new TPad("STU-500", 300, 360, 390, 16, 22, 32, 110, 260, 0, 180, 30, 100);
                    zoom = 50;
                    break;
                case 800:    Pad = new TPad("STU-520 or STU-530", 300, 360, 390, 16, 22, 32, 110, 340, 0, 180, 50, 100);
                    zoom = 50;
                    break;
                case 320:    Pad = new TPad("STU-430 or ePad", 100, 130, 150, 10, 12, 16, 110, 120, 0, 45, 30, 15);
                    zoom = 100;
                    break;
                default: Pad = false;
            }
            WizCtl.Zoom = zoom;
        }
    }



//================================ PadEventHandler ================================
    function PadEventHandler( Ctl, Id, Type ) {
        //setTimeout("StepHandler('" + Id + "')",0);
        StepHandler(Ctl,Id,Type);
    }

    function SetEventHandler( handler ) {
      WizCtl.SetEventHandler( PadEventHandler );
      StepHandler = handler;
    }

    /////////////////////////// WACOM SCRIPT //////////////////////
//================================ StepControl     ================================

    function SendQuestionsAuth() {
        try {
            WizCtl.Reset();
            WizCtl.Font.Name = "Verdana";
            WizCtl.Font.Bold = false;
            WizCtl.Font.Size = Pad.textFontSize;

            WizCtl.AddObject(WizObject.Checkbox, "chk", "center", "middle", "{{ __('sign.sign_proc_auth_question')}} ", null );

            WizCtl.Font.Size = Pad.buttonFontSize;
            WizCtl.AddObject(WizObject.Button, "Cancel", "left", "bottom", "Cancel", Pad.buttonWith );
            WizCtl.AddObject(WizObject.Button, "Next", "right", "bottom", "Next", Pad.buttonWith );

            WizCtl.Display();
            SetEventHandler(Auth_Hendler);
        } catch ( ex ) {
            Exception( "questionsAuth() " + ex.message);
        }
    }
    function Auth_Hendler(Ctl, Id, Type) {
        switch(Id) {
            case "Next":
                if (WizCtl.GetObjectState("chk")){
                    print('Next');
                    sendQuestions();
                } else {
                    print('NoNext');
                    stopWizard();
                }
                break;
            case "Cancel":
                print("Cancel");
                stopWizard();
                break;
            case "chk":
                print(WizCtl.GetObjectState("chk"));
                break;
            default:
                Error("Unexpected Step1 event: " + Id);
                break;
        }
    }

    function sendQuestions() {
        try {
            if (ctlScript < questions.length && questions[ctlScript] != ""){
                WizCtl.Reset();
                WizCtl.Font.Name = "Verdana";
                WizCtl.Font.Bold = false;
                WizCtl.Font.Size = Pad.textFontSize;

                WizCtl.AddObject(WizObject.Checkbox, "chk2", "center", "middle", escapeHtml(questions[ctlScript][5]), null );

                WizCtl.Font.Size = Pad.buttonFontSize;
                WizCtl.AddObject(WizObject.Button, "Cancel", "left", "bottom", "Cancel", Pad.buttonWith );
                WizCtl.AddObject(WizObject.Button, "Next", "right", "bottom", "Next", Pad.buttonWith );

                WizCtl.Display();
                SetEventHandler(Step_Handler);
            } else {
                $('#questions').val(JSON.stringify(responseQuestions));
                ctlScript = 0;
                toastr['warning']("{{__('sign.sign_proc_sign_start')}}", "{{ __('sign.sign_proc_start_sign_optional') }}");
                sendOptionalSign()
            }
        } catch ( ex ) {
            Exception( "questions("+ctlScript+") " + ex.message);
        }
    }
    function Step_Handler(Ctl,Id,Type) {
        switch(Id) {
            case "Next":
                if (WizCtl.GetObjectState("chk2")) {
                    responseQuestions[ctlScript] = true;
                } else {
                    responseQuestions[ctlScript] = false;
                }
                print("ctlScript: "+ctlScript);
                ctlScript++;
                sendQuestions();
                break;
            case "Cancel":
                print("Cancel");
                stopWizard();
                break;
            case "chk2":
                print(WizCtl.GetObjectState("chk2"));
                break;
            default:
                Error("Unexpected Step2 event: " + Id);
                break;
        }
    }

    function sendOptionalSign() {
        try {
            if (ctlScript < templates.length && templates[ctlScript] != ""){
                if(templates[ctlScript][3].toUpperCase() == 'O'){
                    WizCtl.Reset();
                    WizCtl.Font.Name = "Verdana";
                    WizCtl.Font.Bold = false;
                    WizCtl.Font.Size = Pad.textFontSize;

                    WizCtl.AddObject(WizObject.Checkbox, "chk3", "center", "middle", escapeHtml(templates[ctlScript][4]), null );

                    WizCtl.Font.Size = Pad.buttonFontSize;
                    WizCtl.AddObject(WizObject.Button, "Cancel", "left", "bottom", "Cancel", Pad.buttonWith );
                    WizCtl.AddObject(WizObject.Button, "Next", "right", "bottom", "Next", Pad.buttonWith );

                    WizCtl.Display();
                    SetEventHandler(StepOptional_Handler);
                } else {
                    responseTemplates[ctlScript] = false;
                    ctlScript++;
                    sendOptionalSign();
                }
            } else {
                $('#templates').val(JSON.stringify(responseTemplates));
                stopWizard();
                toastr['warning']("{{__('sign.sign_proc_sign_start')}}", "{{__('sign.sign_proc_start_title')}}");
                Capture();
            }
        } catch ( ex ) {
            Exception( "questions("+ctlScript+") " + ex.message);
        }
    }
    function StepOptional_Handler(Ctl,Id,Type) {
        switch(Id) {
            case "Next":
                if (WizCtl.GetObjectState("chk3")) {
                    responseTemplates[ctlScript] = true;
                } else {
                    responseTemplates[ctlScript] = false;
                }
                print("ctlScript: "+ctlScript);
                ctlScript++;
                sendOptionalSign();
                break;
            case "Cancel":
                print("Cancel");
                stopWizard();
                break;
            case "chk3":
                print(WizCtl.GetObjectState("chk3"));
                break;
            default:
                Error("Unexpected Step3 event: " + Id);
                break;
        }
    }

    function stopWizard() {
        ctlScript = 0;
        WizCtl.Reset();
        WizCtl.PadDisconnect();
        print("Pad disconnected");
        //toastr['error']("{{__('sign.sign_proc_drop')}}", "{{__('sign.sign_proc_start_title')}}");
    }

    /**
     * Save configuration of a Wacom Pad
     * */
    function TPad(model, signatureLineY, whoY, whyY, textFontSize, buttonFontSize, signLineSize, buttonWith) {
        this.model = model;
        this.signatureLineY = signatureLineY;
        this.whoY = whoY;
        this.whyY = whyY;
        this.buttonWith = buttonWith;
        this.textFontSize = textFontSize;
        this.buttonFontSize = buttonFontSize;
        this.signLineSize = signLineSize;
    }

    function Capture() {

        toastr['info']("{{__('sign.sign_proc_sign_start')}}", "{{__('sign.sign_proc_start_title')}}");
        var sigCtl = new ActiveXObject("Florentis.SigCtl");
        var dc = new ActiveXObject("Florentis.DynamicCapture");
        sigCtl.SetProperty("Licence",Licence);
        sigCtl.BackStyle = 1;
        sigCtl.DisplayMode=0; // fit signature to control
        try {
            print("Capturing signature...");
            GenerateHash();
            var rc = dc.Capture(sigCtl, "{{$document->name}}", "{{$document->dossier->client->surname.' '.$document->dossier->client->name}}", hash, null);
            print("Capture returned: " + rc);
            switch( rc ) {
                case 0: // CaptureOK
                    print("Signature captured successfully");
                    flags = 0x2000 + 0x80000 + 0x400000 + 0x10000; //SigObj.outputBase64 | SigObj.color32BPP | SigObj.encodeData | SigObj.BackgroundTransparent
                    b64 = sigCtl.Signature.RenderBitmap("", 300, 150, "image/png", 1, 0xff0000, 0xffffff, 0.0, 0.0, flags );
                    var imgSrcData = "data:image/png;base64,"+b64;
                    $('#b64image').attr("src",imgSrcData);
                    $("#imgB64").val(imgSrcData);
                    toastr['success']("{{__('sign.sign_proc_success')}}", "{{__('sign.sign_proc_success_title')}}");
                    break;
                case 1: // CaptureCancel
                    print("Signature capture cancelled");
                    break;
                case 100: // CapturePadError
                    print("No capture service available");
                    break;
                case 101: // CaptureError
                    print("Tablet Error");
                    break;
                case 102: // CaptureIntegrityKeyInvalid
                    print("The integrity key parameter is invalid (obsolete)");
                    break;
                case 103: // CaptureNotLicensed
                    print("No valid Signature Capture licence found");
                    break;
                case 200: // CaptureAbort
                    print("Error - unable to parse document contents");
                    break;
                default:
                    print("Capture Error " + rc);
                    break;
            }
        }
        catch(ex) {
            Exception("Capture() error: " + ex.message);
        }
    }

    function GenerateHash() {
            print("Creating document hash:");
            hash.Clear();
            hash.Type = 4; // MD5
            hash.add(pdfData);
            print("hash: "+hash.Hash);
            //return hash;
    }

    function Error(txt) {
        stopWizard();
        print("Error: " + txt);
        toastr['error'](txt, "{{__('sign.sign_proc_start_title')}}");
    }
    function Exception(txt) {
        stopWizard();
        print("Exception: " + txt);
        toastr['error'](txt, "{{__('sign.sign_proc_start_title')}}");
        WacomCtl=false;

    }
    function print(txt) {
        @if(config('app.debug'))
        var txtDisplay = document.getElementById("txtDisplay");
        if(txt == "CLEAR" )
            txtDisplay.value = "";
        else {
            txtDisplay.value += txt + "\n";
            txtDisplay.scrollTop = txtDisplay.scrollHeight; // scroll to end
        }
        @endif
    }

    function OnLoad() {
        try {
            if( !("ActiveXObject" in window) ) {
                //document.getElementById("not_ie_warning").style.display="block";
                WacomCtl=false;
            } else {
                WacomCtl=true;
                WizCtl = new ActiveXObject("Florentis.WizCtl"),
                lic  = new ActiveXObject("Wacom.Signature.Licence"),
                Licence = 'AgAkAMlv5nGdAQVXYWNvbQ1TaWduYXR1cmUgU0RLAgOBAgJkAACIAwEDZQA',
                hash = new ActiveXObject('Florentis.Hash');

                lic.SetLicence(Licence);
            }
            print("CLEAR");

        }
        catch(ex) {
            Exception("OnLoad() error: " + ex.message);
        }
    }

    OnLoad();


/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    var pdfDoc = null
        pageNum = 1,
        pageRendering = false,
        pageNumPending = null,
        //scale = 1.5,
        canvas = $('#pdf-canvas').get(0),
        //canvasContainer = $('#div-pdf-canvas').get(0)
        //url = $('#pdf-canvas').attr('data-url'),
        ctx = canvas.getContext('2d');

    /**
     * Get page info from document, resize canvas accordingly, and render page.
     * @param num Page number.
     */
    function renderPage(num) {
        pageRendering = true;
        // Using promise to fetch the page
        pdfDoc.getPage(num).then(function(page) {

            //var canvas = document.createElement('canvas');
            var container = document.getElementById('div-pdf-canvas');
            var canvas = document.getElementById('pdf-canvas');
            ctx = canvas.getContext('2d');

            var viewport = page.getViewport(1);
            var scale = container.clientWidth / viewport.width;
            viewport = page.getViewport(scale);

            canvas.height = viewport.height;
            canvas.width = viewport.width;

            // Render PDF page into canvas context
            var renderContext = {
                canvasContext: ctx,
                viewport: viewport
            };

            var renderTask = page.render(renderContext);

            // Wait for rendering to finish
            renderTask.promise.then(function() {
                pageRendering = false;
                if (pageNumPending !== null) {
                    // New page rendering is pending
                    renderPage(pageNumPending);
                    pageNumPending = null;
                }
            });
        });

        // Update page counters
        document.getElementById('page_num').textContent = pageNum;
    }

    /**
     * If another page rendering in progress, waits until the rendering is
     * finised. Otherwise, executes rendering immediately.
     */
    function queueRenderPage(num) {
        if (pageRendering) {
            pageNumPending = num;
        } else {
            renderPage(num);
        }
    }

    /**
     * Displays previous page.
     */
    function onPrevPage() {
        if (pageNum <= 1) {
            return;
        }
        pageNum--;
        queueRenderPage(pageNum);
    }
    document.getElementById('prev').addEventListener('click', onPrevPage);

    /**
     * Displays next page.
     */
    function onNextPage() {
        if (pageNum >= pdfDoc.numPages) {
            return;
        }
        pageNum++;
        queueRenderPage(pageNum);
    }
    document.getElementById('next').addEventListener('click', onNextPage);

    /**
     * Asynchronously downloads PDF.
     */
    //PDFJS.getDocument(url).then(function(pdfDoc_) {
    PDFJS.getDocument({data: pdfData}).then(function(pdfDoc_) {
        pdfDoc = pdfDoc_;
        document.getElementById('page_count').textContent = pdfDoc.numPages;
        // Initial/first page rendering
        renderPage(pageNum);
    });

    $('#pdf-canvas').change(function(e){
        console.log('canvas changed.......');
    });


    $('.i-checks').iCheck({
        checkboxClass: 'icheckbox_square-green',
        radioClass: 'iradio_square-green',
    });

})
</script>
@endpush
@section('content')
<div class="row">
    <div class="col-lg-12 col-md-12 col-xs-12">
        <div class="ibox float-e-margins col-lg-12 col-md-12 col-xs-12">
            <div class="ibox-title col-lg-12 col-md-12 col-xs-12">
                <h5>{{__('sign.sign-pdf-title')}}</h5>
                <div ibox-tools="" class="ng-scope">
                    <div dropdown="" class="ibox-tools dropdown">
                        <a href="{{ url('sign') }}"><button class="btn btn-primary dim"> <i class="fa fa-arrow-left"></i></button></a>
                    </div>
                </div>
            </div>
            <hr>

            <div class="ibox-content col-lg-12 col-md-12 col-xs-12">
                <div class="pull-left col-lg-9 col-md-9 col-xs-9 ">
                    <button id="prev" class="col-lg-4 col-md-4 col-xs-4 pull-left btn btn-info">Previous</button>
                    <div class="col-lg-4 col-md-4 col-xs-4 text-center"><span>Page: <span id="page_num"></span> / <span id="page_count"></span></span></div>
                    <button id="next" class="col-lg-4 col-md-4 col-xs-4 pull-right btn btn-info">Next</button>
                </div>

                <div class="pull-right col-lg-3 col-md-3 col-xs-3">
                    <div>
                        <h2 class="text-center">{{__('sign.sign_pdf_wacom_title')}}</h2>
                        <!--[if !IE]>-->
                        <div id="not_ie_warning" style="display:none">
                            <h2 class="text-center">WARNING:</h2>
                            This application is only supported by Internet Explorer<br/>
                            (The Javascript uses ActiveX controls which are not supported by alternative browsers such as Firefox)<br/>
                        </div>
                        <!--<![endif]-->
                        <form method="POST" action="{{ route('sign.store_signing',['id' => $document->id]) }}" id="toast-form">
                        {!! csrf_field() !!}{{ method_field('PUT') }}
                        <table>
                            <tr>
                                <td rowspan="3" class="col-md-2">
                                    <div class="hidden">
                                        <object id="sigCtl1" classid="clsid:963B1D81-38B8-492E-ACBE-74801D009E9E"></object>
                                        <input type="hidden" name="imgB64[]"  id="imgB64"/>
                                    </div>
                                    <img name="img64[]" id="b64image" style="width:12vw;height:12vh">
                                    <input id="questions" type="hidden" name="questions" value="" />
                                    <input id="templates" type="hidden" name="templates" value="" />
                                </td>
                                <td  style="padding: 10px 10px;">
                                    <input id="start" type="button" class="btn btn-block btn-outline btn-warning"  title="Starts signature capture" value="Start" />
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 10px 10px;">
                                @if(config('app.debug'))
                                    <input id="about" type="button" class="btn btn-block btn-outline btn-danger"  title="Starts signature capture" value="Info" />
                                @endif
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 10px 10px;">
                                    <button class="btn btn-block btn-outline btn-primary"  title="Starts signature capture"   data-form-id="toast-form">Submit</button>
                                </td>
                            </tr>
                        </table>
                        </form>

                        @if(config('app.debug'))
                        <br/>
                        <textarea cols="40" rows="10" id="txtDisplay"></textarea>
                        @endif
                    </div>
                </div>

                <div class="pull-left col-lg-9 col-md-9 col-xs-9 text-center" id="div-pdf-canvas">

                    <canvas id="pdf-canvas" height="100%" width="100%"></canvas>
                </div>

            </div>
        </div>
    </div>
</div>


<div class="modal inmodal fade in" id="showModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content animated flipInY">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="modal-title" name="name">Firma del Documento</h4>
            </div>
            <div class="modal-body" style="height: 30vh">
                <!--<div id="signature"></div>-->
            </div>
            <div class="modal-footer">
                <div class="row">
                    <div id="tools" class="form-group">
                        <div class="col-lg-5 col-md-5 col-xs-5 pull-left">
                            <button class="btn btn-block btn-outline btn-danger" id="Sig-Reset">Reset</button>
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

@endsection