@extends('frontend.front')
@push('scripts')
<script src="{{ asset('js/pdf.js') }}"></script>
<script src="{{ asset('js/compatibility.js') }}"></script>
<script src="{{ asset('js/jspdf.min.js') }}"></script>
<script>

    var Licence = 'AgAkAMlv5nGdAQVXYWNvbQ1TaWduYXR1cmUgU0RLAgOBAgJkAACIAwEDZQA';
    function Capture() {
        try {
            print("Capturing signature...");
            var sigCtl = document.getElementById("sigCtl1");
            var dc = new ActiveXObject("Florentis.DynamicCapture");
            var rc = dc.Capture(sigCtl, "{{$document->name}}", "{{$document->dossier->client->surname.' '.$document->dossier->client->name}}");
            if(rc != 0 )
                print("Capture returned: " + rc);
            switch( rc ) {
                case 0: // CaptureOK
                    print("Signature captured successfully");
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

    function Exception(txt) {
        print("Exception: " + txt);
    }
    function print(txt) {
        var txtDisplay = document.getElementById("txtDisplay");
        if(txt == "CLEAR" )
            txtDisplay.value = "";
        else {
            txtDisplay.value += txt + "\n";
            txtDisplay.scrollTop = txtDisplay.scrollHeight; // scroll to end
        }
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


    /////////////// JSPDF


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
                <div style="height: 500px;overflow-y: auto" class="pull-left col-lg-6">

                  <button id="prev" class="col-lg-6">Previous</button>
                  <button id="next" class="col-lg-6">Next</button>
                  &nbsp; &nbsp;
                  <span>Page: <span id="page_num"></span> / <span id="page_count"></span></span>


                    <canvas id="pdf-canvas" class="pull-left" ></canvas>

                </div>
                <div class="pull-right col-lg-6">
                    <div>
                        <h2>Test Signature Control</h2>
                        <div id="not_ie_warning" style="display:none">
                            <h2>WARNING:</h2>
                            This application is only supported by Internet Explorer<br/>
                            (The Javascript uses ActiveX controls which are not supported by alternative browsers such as Firefox)<br/>
                        </div>
                        <table style="padding: 10px 90px;">
                            <tr>
                                <td rowspan="3">
                                    <div>
                                        <object id="sigCtl1" style="width:60mm;height:35mm"
                                                type="application/x-florentis-signature">
                                        </object>
                                    </div>
                                </td>
                                <td  style="padding: 10px 50px;">
                                    <input type="button" value="Start" style="height:10mm;width:35mm" onclick="Capture()"
                                           title="Starts signature capture" />
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 10px 50px;">
                                    <input type="button" value="About" style="height:10mm;width:35mm" onclick="AboutBox()"
                                           title="Displays the Help About box" />
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 10px 50px;">
                                    <input type="button" value="Info" style="height:10mm;width:35mm" onclick="DisplaySignatureDetails()"
                                           title="Displays the signature details" />
                                </td>
                            </tr>
                        </table>
                        <br/>
                        <textarea cols="50" rows="15" id="txtDisplay"></textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(function () {
///////// PDFJS
    var url = '{{ asset('storage')}}/documents/{{$document->filename}}';
    var pdfDoc = null,
        pageNum = 1,
        pageRendering = false,
        pageNumPending = null,
        scale = 0.8,
        canvas = document.getElementById('pdf-canvas'),
        ctx = canvas.getContext('2d');

    /**
     * Get page info from document, resize canvas accordingly, and render page.
     * @param num Page number.
     */
    function renderPage(num) {
        pageRendering = true;
        // Using promise to fetch the page
        pdfDoc.getPage(num).then(function(page) {
            var viewport = page.getViewport(scale);
            canvas.height = viewport.height;
            canvas.width = viewport.width;
            //canvas.height = '500px';
            //canvas.width = '500px';

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
    PDFJS.getDocument(url).then(function(pdfDoc_) {
        pdfDoc = pdfDoc_;
        document.getElementById('page_count').textContent = pdfDoc.numPages;

        // Initial/first page rendering
        renderPage(pageNum);
    });

////////// WACOM

    OnLoad();
})
    
</script>

@endsection