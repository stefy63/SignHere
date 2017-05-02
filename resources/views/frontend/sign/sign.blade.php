@extends('frontend.front')
@push('scripts')
<script src="{{ asset('js/pdf.js') }}"></script>
<script src="{{ asset('js/compatibility.js') }}"></script>

<!--<script src="{{ asset('js/jspdf.min.js') }}"></script>-->
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
                <div style="height: 100px;" class="pull-left">

                  <button id="prev">Previous</button>
                  <button id="next">Next</button>
                  &nbsp; &nbsp;
                  <span>Page: <span id="page_num"></span> / <span id="page_count"></span></span>


                    <canvas id="pdf-canvas" width="100px" height="100px"></canvas>

                </div>
                <div class="pull-right">
                    <object id="sigCtl1" style="width:80mm;height:45mm"
                            type="application/x-florentis-signature">
                    </object>
                    <div  style="padding: 10px 50px;">
                        <input type="button" value="Sign" style="height:10mm;width:35mm" onclick="Capture()"
                               title="Starts signature capture" />
                    </div>
                    <br/>
                    <textarea cols="30" rows="10" id="txtSignature"></textarea>
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
    var Licence = 'AgAkAMlv5nGdAQVXYWNvbQ1TaWduYXR1cmUgU0RLAgOBAgJkAACIAwEDZQA';

    try {
          //print("CLEAR");
          var sigCtl = document.getElementById("sigCtl1");
          SigCtl.Licence = Licence;
          sigCtl.BackStyle = 1;
          sigCtl.DisplayMode=0; // fit signature to control
          //print("Checking components...");
          var sigcapt = new ActiveXObject('Florentis.DynamicCapture');  // force 'can't create object' error if components not yet installed
          var lic = new ActiveXObject("Wacom.Signature.Licence");
          //print("DLL: Licence.dll   v" + lic.GetProperty("Component_FileVersion"));
          //print("DLL: flSigCOM.dll  v" +   sigCtl.GetProperty("Component_FileVersion"));
          //print("DLL: flSigCapt.dll v" + sigcapt.GetProperty("Component_FileVersion"));
          //print("Test application ready.");
          //print("Press 'Sign' to capture a signature.");
        }
        catch(ex) {
          Exception("OnLoad() error: " + ex.message);
        }


        function Capture() {
        try {
          //print("Capturing signature...");
          var sigCtl = document.getElementById("sigCtl1");
          var dc = new ActiveXObject("Florentis.DynamicCapture");
          var rc = dc.Capture(sigCtl, "{{$document->name}}", "{{$document->dossier->name}}");
          if(rc != 0 )
            //print("Capture returned: " + rc);
          switch( rc ) {
            case 0: // CaptureOK
              //print("Signature captured successfully");
              var txtSignature = document.getElementById("txtSignature");
              flags = 0x2000 + 0x80000 + 0x400000; //SigObj.outputBase64 | SigObj.color32BPP | SigObj.encodeData
              b64 = sigCtl.Signature.RenderBitmap("", 300, 150, "image/png", 0.5, 0xff0000, 0xffffff, 0.0, 0.0, flags );
              txtSignature.value=b64;
              var imgSrcData = "data:image/png;base64,"+b64;
              document.getElementById("b64image").src=imgSrcData;
              break;
            case 1: // CaptureCancel
              //print("Signature capture cancelled");
              break;
            case 100: // CapturePadError
              //print("No capture service available");
              break;
            case 101: // CaptureError
              //print("Tablet Error");
              break;
            case 102: // CaptureIntegrityKeyInvalid
              //print("The integrity key parameter is invalid (obsolete)");
              break;
            case 103: // CaptureNotLicensed
              //print("No valid Signature Capture licence found");
              break;
            case 200: // CaptureAbort
              //print("Error - unable to parse document contents");
              break;
            default:
              //print("Capture Error " + rc);
              break;
          }
        }
        catch(ex) {
          Exception("Capture() error: " + ex.message);
        }
      }

/////////////// JSPDF



})
    
</script>

@endsection