@extends('frontend.front')
@push('scripts')
<script src="{{ asset('js/pdf.js') }}"></script>
<script src="{{ asset('js/compatibility.js') }}"></script>
<script>

    var Licence = 'AgAkAMlv5nGdAQVXYWNvbQ1TaWduYXR1cmUgU0RLAgOBAgJkAACIAwEDZQA',
        //var sigCtl = document.getElementById("sigCtl1"),
        sigCtl = new ActiveXObject("Florentis.SigCtl"),
        dc = new ActiveXObject("Florentis.DynamicCapture"),
        hasher = new ActiveXObject('Florentis.Hash'),
        WizCtl = new ActiveXObject("Florentis.WizCtl");

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


    function Start() {
        /*
        - richiesta autorizzazione firma digitale documento
        - ciclo richieste da DB e memorizzazione risposte
        - ciclo firme se multiple o firma se singola
        - elaborazione documento firmato con risposte facoltative e firme
        - richiesta conferma firma con visualizzazione
        - fine
        */
        sendQuestions();
        Capture();


    }

    function sendQuestions() {
        var questions = "{{$questions}}";
        console.log(questions);
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


    function Capture(e) {
        try {
            print("Capturing signature...");
            GenerateHash(hasher);
            var rc = dc.Capture(sigCtl, "{{$document->name}}", "{{$document->dossier->client->surname.' '.$document->dossier->client->name}}", hasher);
            if(rc != 0)
                print("Capture returned: " + rc);
            switch( rc ) {
                case 0: // CaptureOK
                    print("Capture returned: " + rc);
                    print("Signature captured successfully");
                    print(hasher.Hash.toString());
                    toastr['success']("{{__('sign.sign_proc_success')}}", "{{__('sign.sign_proc_success_title')}}");
                    flags = 0x2000 + 0x80000 + 0x400000; //SigObj.outputBase64 | SigObj.color32BPP | SigObj.encodeData
                    b64 = sigCtl.Signature.RenderBitmap("", 300, 150, "image/png", 0.5, 0xff0000, 0xffffff, 0.0, 0.0, flags );
                    var imgSrcData = "data:image/png;base64,"+b64;
                    document.getElementById("b64image").src=imgSrcData;
                    document.getElementById("imgB64").src=imgSrcData;
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

    function GenerateHash(hasher) {
            print("Creating document hash:");
            hasher.Clear();
            hasher.Type = 1; // MD5

            //var base64 = '{{$b64doc}}';
            //print(base64);
            //hasher.add(base64);
            hasher.add(pdfData);

            print("hash: "+hasher.Hash);

    }


    function DisplaySignatureDetails() {
        try {
            var sigCtl = document.getElementById("sigCtl1");
            if (sigCtl.Signature.IsCaptured) {
                print("Signature Information:");
                print("  Name:   " + sigCtl.Signature.Who);
                print("  Date:   " + sigCtl.Signature.When);
                print("  Reason: " + sigCtl.Signature.Why);
            }
            else
            {
                print("No signature captured");
            }
        }
        catch(ex) {
            Exception("DisplaySignatureDetails() error: " + ex.message);
        }
    }

    function AboutBox() {
        try {
            var sigCtl = document.getElementById("sigCtl1");
            sigCtl.AboutBox();
        }
        catch(ex) {
            Exception("About() error: " + ex.message);
        }
    }

    function Error(txt) {
        print("Error: " + txt);
    }
    function Exception(txt) {
        print("Exception: " + txt);
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
                document.getElementById("not_ie_warning").style.display="block";
                return;
            }
            print("CLEAR");
            var sigCtl = document.getElementById("sigCtl1");
            sigCtl.SetProperty("Licence",Licence);
            sigCtl.BackStyle = 1;
            sigCtl.DisplayMode=0; // fit signature to control
            print("Checking components...");
            var sigcapt = new ActiveXObject('Florentis.DynamicCapture');  // force 'can't create object' error if components not yet installed
            var lic = new ActiveXObject("Wacom.Signature.Licence");
            print("DLL: Licence.dll   v" + lic.GetProperty("Component_FileVersion"));
            print("DLL: flSigCOM.dll  v" +   sigCtl.GetProperty("Component_FileVersion"));
            print("DLL: flSigCapt.dll v" + sigcapt.GetProperty("Component_FileVersion"));
            print("Test application ready.");
            print("Press 'Start' to capture a signature.");
        }
        catch(ex) {
            Exception("OnLoad() error: " + ex.message);
        }
    }




</script>
@endpush
@section('content')
<div class="row">
    @if($document->doctype){{ $document->doctype->template }}@endif
    <div class="col-lg-12">
        <div class="ibox float-e-margins col-lg-12">
            <div class="ibox-title">
                <h5>{{__('sign.sign-pdf-title')}}</h5>
                <div ibox-tools="" class="ng-scope">
                    <div dropdown="" class="ibox-tools dropdown">
                        <a href="{{ url('sign') }}"><span class="badge badge-info"> <i class="fa fa-arrow-left"></i></span></a>
                    </div>
                </div>
            </div>
            <hr>
            <div class="ibox-content col-lg-12">
                <div class="pull-left col-lg-9 ">
                    <button id="prev" class="col-lg-5 pull-left btn btn-info">Previous</button>
                    <div class="col-lg-2 text-center"><span>Page: <span id="page_num"></span> / <span id="page_count"></span></span></div>
                    <button id="next" class="col-lg-5 pull-right btn btn-info">Next</button>
                </div>

                <div class="pull-right col-lg-3">
                    <div>
                        <h2>{{__('sign.sign_pdf_wacom_title')}}</h2>
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
                                        <!--<object id="sigCtl1" type="application/x-florentis-signature"></object>-->
                                        <object id="sigCtl1" classid="clsid:963B1D81-38B8-492E-ACBE-74801D009E9E"></object>
                                        <input type="hidden" name="imgB64[]"  id="imgB64"/>
                                    </div>
                                    <img name="img64[]" id="b64image" style="width:12vw;height:12vh">
                                </td>
                                <td  style="padding: 10px 10px;">
                                    <input type="button" class="btn btn-block btn-outline btn-warning"  title="Starts signature capture" onclick="sendQuestions();" value="Start" />
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 10px 10px;">
                                @if(config('app.debug'))
                                    <input type="button" class="btn btn-block btn-outline btn-danger"  title="Starts signature capture" onclick="AboutBox()" value="Info" />
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

                <div style="height: 70vh;overflow: auto" class="pull-left col-lg-9 text-center" id="div-pdf-canvas">

                    <canvas id="pdf-canvas" height="100%" width="100%"></canvas>

                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(function () {
///////// PDFJS

    var pdfDoc = null,
        pdfData = atob("{{$b64doc}}"),
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
            var desiredWidth = 1100;
            var viewport2 = page.getViewport(1);
            var scale = desiredWidth / viewport2.width;

            var viewport = page.getViewport(scale);
            canvas.height = viewport.height;
            canvas.width = viewport.width;
            ctx = canvas.getContext('2d');

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


////////// WACOM

    OnLoad();

///////////// FORM

    $('form#toast-form').submit(function(e){
        e.preventDefault();
        $('input[name=imgB64]').val($('img#b64image').src);
    });
    //$('#imgB64').val("FDKSJFKDSJFJSDLFKSDLKFJSDKLFJLDSKJFLSD");
})

/*
    function renderPDF(url, canvasContainer, options) {
    var options = options || { scale: 1 };

    function renderPage(page) {
        var viewport = page.getViewport(options.scale);
        var canvas = document.createElement('canvas');
        var ctx = canvas.getContext('2d');
        var renderContext = {
          canvasContext: ctx,
          viewport: viewport
        };

        canvas.height = viewport.height;
        canvas.width = viewport.width;
        canvasContainer.appendChild(canvas);

        page.render(renderContext);
    }

    function renderPages(pdfDoc) {
        for(var num = 1; num <= pdfDoc.numPages; num++)
            pdfDoc.getPage(num).then(renderPage);
    }
    PDFJS.disableWorker = true;
    PDFJS.getDocument(url).then(renderPages);
}
*/

</script>

@endsection