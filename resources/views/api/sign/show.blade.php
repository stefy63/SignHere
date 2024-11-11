@extends('api.front')
@push('assets')
<link href="{{ asset('css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css') }}" rel="stylesheet">
<link href="{{ asset('font-awesome/css/font-awesome.css') }}" rel="stylesheet">
<link href="{{ asset('css/plugins/iCheck/custom.css') }}" rel="stylesheet">
<link href="{{ asset('css/jquery-ui.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="row">
    <div class="col-lg-12 col-md-12 col-xs-12">
        <div class="ibox float-e-margins col-lg-12 col-md-12 col-xs-12">
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
