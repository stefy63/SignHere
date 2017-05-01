@extends('frontend.front')
@push('scripts')
<script src="{{ asset('js/pdf.js') }}"></script>
<script src="{{ asset('js/compatibility.js') }}"></script>
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
                <!--<iframe src="{{ asset('storage')}}/documents/{{$document->filename}}" width="500" height="700"></iframe>
                <div id="pdf" class="col-lg-10">
                  <object width="80%" height="700px" type="application/pdf" data="{{ asset('storage')}}/documents/{{$document->filename}}" id="pdf_content">
                    <p>ERROR. Object not found</p>
                  </object>-->
                    <div>
                      <button id="prev">Previous</button>
                      <button id="next">Next</button>
                      &nbsp; &nbsp;
                      <span>Page: <span id="page_num"></span> / <span id="page_count"></span></span>
                    </div>
                    <canvas id="canvas"></canvas>
                </div>
                    <object id="SigCtl" style="width:'80mm';height:'62mm'"
                        classid="clsid:F5DC9DFE-FD38-4455-A783-4B3F31B2D229"
                        codebase="wgssSig.cab">Unable to install/load Wacom Signature Components
                    </object>

                <input type="button" onclick="btn_onclick()" value="Click!"/>
            </div>
        </div>
    </div>
</div>

<script>
$(function () {

    var url = '{{ asset('storage')}}/documents/{{$document->filename}}';
    var pdfDoc = null,
        pageNum = 1,
        pageRendering = false,
        pageNumPending = null,
        scale = 0.8,
        canvas = document.getElementById('canvas'),
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


    function btn_onclick() {
        try {
          var sigCtl = document.getElementById("SigCtl");

          sigCtl.AboutBox();
        }
        catch (e) {
          alert(e);
        }
    }

    function detect_ActiveX() {
      if(typeof(window.ActiveXObject)=="undefined"){
            alert("ActiveX is not supported by this browser!");
        }
      }
    detect_ActiveX();
})
    
</script>

@endsection