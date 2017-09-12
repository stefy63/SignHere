<template>
    <div>
        <div>
            <button v-on:click="onPrevPage" class="col-lg-4 col-md-4 col-xs-4 pull-left btn btn-info">Previous</button>
            <div class="col-lg-4 col-md-4 col-xs-4 text-center"><span>Page: <span>{{pageNum}}</span> / <span>{{page_count}}</span></span></div>
            <button v-on:click="onNextPage" class="col-lg-4 col-md-4 col-xs-4 pull-right btn btn-info">Next</button>
            <button v-on:click="onPutSign" class="col-lg-4 col-md-4 col-xs-4 pull-right btn btn-info">Sign</button>
        </div>
        <canvas id="tst"></canvas>
        <div  id="div-pdf-canvas">
            <canvas id="pdf-canvas"></canvas>
        </div>
    </div>
</template>

<script>

require('pdfjs-dist');
require('pdfjs-dist/build/pdf.worker');

export default {
    props: [
        'pdfdata'
    ],
    data: function () {

        return {
            pdfDocData: atob(this.pdfdata),
            pdfDoc:'',
            page_count: 0,
            pageNum: 1,
            pageRendering: false,
            pageNumPending: null,
            container: '',
            canvas: '',
            ctx: ''
        };
    },
    created:function () {
        var vm = this;
        PDFJS.getDocument({data: atob(this.pdfdata)}).then(function(pdfDoc_) {
            vm.pdfDoc = pdfDoc_;
            vm.page_count = vm.pdfDoc.numPages;
            vm.renderPage(vm.pageNum);
        })
        window.onresize = this.resizeCanvas;
    },
    computed: function () {
    },
    methods:{
        renderPage: function (num) {
            var vm = this;
            vm.pageRendering = true;
            // Using promise to fetch the page
            vm.pdfDoc.getPage(num).then(function(page) {

                vm.container = $('#div-pdf-canvas').get(0);
                vm.canvas = $('#pdf-canvas').get(0);
                vm.ctx = vm.canvas.getContext('2d');

                var viewport = page.getViewport(1);
                var scale = vm.container.clientWidth / viewport.width;
                viewport = page.getViewport(scale);

                vm.canvas.height = viewport.height;
                vm.canvas.width = viewport.width;

                // Render PDF page into canvas context
                var renderContext = {
                    canvasContext: vm.ctx,
                    viewport: viewport
                };

                var renderTask = page.render(renderContext);

                // Wait for rendering to finish
                renderTask.promise.then(function() {
                    vm.pageRendering = false;
                    if (vm.pageNumPending !== null) {
                        // New page rendering is pending
                        vm.renderPage(vm.pageNumPending);
                        vm.pageNumPending = null;
                    }
                });

            });

        },
        queueRenderPage: function(num) {
            var vm = this;
            if (vm.pageRendering) {
                vm.pageNumPending = num;
            } else {
                vm.renderPage(num);
            }
        },
        onPrevPage: function () {
            if (this.pageNum <= 1) {
                return;
            }
            this.pageNum--;
            this.queueRenderPage(this.pageNum);
        },
        onNextPage: function () {
            if (this.pageNum >= this.pdfDoc.numPages) {
                return;
            }
            this.pageNum++;
            this.queueRenderPage(this.pageNum);
        },
        resizeCanvas: function () {
            var vm = this;
            var ratio =  Math.max(window.devicePixelRatio || 1, 1);
            vm.canvas.width = vm.canvas.offsetWidth * ratio;
            vm.canvas.height = vm.canvas.offsetHeight * ratio;
            vm.canvas.getContext("2d").scale(ratio, ratio);
            vm.queueRenderPage(vm.pageNum);
        },
        onPutSign: function () {
            var vm = this;
            var tstCanvas = $('#tst').get(0);
            var tstCtx = tstCanvas.getContext('2d');
            tstCtx.fillStyle = 'red';
            tstCtx.fillRect(10, 10, 100, 100);
            var tstImg = tstCtx.getImageData(10,10,20,20);
            vm.ctx.putImageData(tstImg,0,0,0,0,20,20);
            vm.queueRenderPage(vm.pageNum);

        }
    }
}

</script>

<style>


</style>