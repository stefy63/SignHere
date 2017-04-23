@extends('admin.back')

@section('content')
@push('scripts')
   <!-- Data picker -->
   <script src="{{ asset('js/plugins/datapicker/bootstrap-datepicker.js') }}"></script>
    <!-- DROPZONE -->
    <script src="{{ asset('js/plugins/dropzone/dropzone.js') }}"></script>
@endpush
@push('assets')
   <!-- Data picker -->
    <link href="{{ asset('css/plugins/datapicker/datepicker3.css') }}" rel="stylesheet">
    <!-- Dropzone -->
    <link href="{{ asset('css/plugins/dropzone/basic.css') }}" rel="stylesheet">
    <link href="{{ asset('css/plugins/dropzone/dropzone.css') }}" rel="stylesheet">
@endpush
<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>{{__('admin_dossiers.create-title')}}</h5>
                <div ibox-tools="" class="ng-scope">
                    <div dropdown="" class="ibox-tools dropdown">
                        <a href="{{ URL::previous() }}"><span class="badge badge-info"> <i class="fa fa-arrow-left"></i></span></a>
                    </div>
                </div>
            </div>
            <hr>

            <form method="POST" action="{{ route('admin_dossiers.update',['id' => $dossier->id]) }}" id="toast-form">
            {!! csrf_field() !!}{{ method_field('PUT') }}

                <div class="row">
                    <div class="form-group">
                        <div class="col-md-2 col-md-offset-1">
                            <label >{{__('admin_dossiers.db-client-name')}}</label>
                        </div>
                        <div class="col-md-8">
                            <input class="form-control" size="50" type="text"  value="{{$dossier->client->name.' - '.$dossier->client->surname}}" disabled/>
                            <input type="hidden" name="client_id" value="{{$dossier->client->id}}">
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="form-group">/file-upload
                        <div class="col-md-2 col-md-offset-1">
                            <label for="name" >{{__('admin_dossiers.db-name')}}</label>
                        </div>
                        <div class="col-md-8">
                            <input class="form-control" size="50" type="text" name="name" value="{{$dossier->name}}" />
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group">
                        <div class="col-md-2 col-md-offset-1">
                            <label for="description" >{{__('admin_dossiers.db-description')}}</label>
                        </div>
                        <div class="col-md-8">
                            <input class="form-control" size="50" type="text" name="description" value="{{$dossier->description}}" />
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group" id="data_dossier">
                        <div class="col-md-2 col-md-offset-1">
                            <label for="date_dossier" >{{__('admin_dossiers.db-date_dossier')}}</label>
                        </div>
                        <div class="col-md-8 input-group date">
                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                            <input class="form-control" type="text"  name="date_dossier" value="{{$dossier->date_dossier}}" />
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group">
                        <div class="col-md-2 col-md-offset-1">
                            <label for="note" >{{__('admin_dossiers.db-note')}}</label>
                        </div>
                        <div class="col-md-8">
                            <input class="form-control" size="50" type="text" name="note" value="{{$dossier->note}}" />
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 text-center">
                        <p><button class="submit-toast btn btn-block btn-outline btn-primary" data-form-id="toast-form">{{__('admin_dossiers.submit')}}</button></p>
                    </div>
                </div>
            </form>

            <div class="col-lg-12">
                <form action="{{ route('admin_dossiers.update',['id' => $dossier->id]) }}" class="dropzone" id="my-dropzone">
                {{ route('admin_dossiers.update',['id' => $dossier->id]) }}
                </form>
            </div>

        </div>
    </div>

</div>
<script>
$(function () {

   Dropzone.options.MyDropzone = {
        autoProcessQueue: false,
        uploadMultiple: true,
        parallelUploads: 100,
        maxFiles: 100,

        // Dropzone settings
        init: function() {
            var myDropzone = this;

            this.element.querySelector("button[type=submit]").addEventListener("click", function(e) {
                e.preventDefault(); class="dropzone"
                e.stopPropagation();
                myDropzone.processQueue();
            });
            this.on("sendingmultiple", function() {
            });
            this.on("successmultiple", function(files, response) {
            });
            this.on("errormultiple", function(files, response) {
            });
        }

    };


    $.fn.datepicker.dates['it'] = {
    days: ["Domenica", "Lunedì", "Martedì", "Mercoledì", "Giovedì", "Venerdì", "Sabato"],
    daysShort: ["Dom", "Lun", "Mar", "Mer", "Gio", "Ven", "Sab"],
    daysMin: ["Do", "Lu", "Ma", "Me", "Gi", "Ve", "Sa"],
    months: ["Gennaio", "Febbraio", "Marzo", "Aprile", "Maggio", "Giugno", "Luglio", "Agosto", "Settembre", "Ottobre", "Novembre", "Dicembre"],
    monthsShort: ["Gen", "Feb", "Mar", "Apr", "Mag", "Giu", "Lug", "Ago", "Set", "Ott", "Nov", "Dic"],
    today: "Oggi",
    clear: "Clear",
    format: "dd/mm/yyyy",
    titleFormat: "MM yyyy", /* Leverages same syntax as 'format' */
    weekStart: 1
    };
     $('#data_dossier input').datepicker({
        language: "it",
        todayBtn: "linked",
        keyboardNavigation: false,
        forceParse: false,
        calendarWeeks: false,
        autoclose: true
    });

})
</script>
@endsection