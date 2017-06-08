@extends('admin.back')

@section('content')
@push('scripts')
   <!-- Data picker -->
   <script src="{{ asset('js/plugins/datapicker/bootstrap-datepicker.js') }}"></script>
@endpush
@push('assets')
   <!-- Data picker -->
    <link href="{{ asset('css/plugins/datapicker/datepicker3.css') }}" rel="stylesheet">
@endpush

<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>{{__('admin_dossiers.create-title')}}</h5>
                <div ibox-tools="" class="ng-scope">
                    <div dropdown="" class="ibox-tools dropdown">
                        <a href="{{ url('admin_documents') }}"><button class="btn btn-primary dim"> <i class="fa fa-arrow-left"></i></button></a>
                    </div>
                </div>
            </div>
            <hr>

            <form method="POST" action="{{ route('admin_dossiers.store') }}" id="toast-form">
            {!! csrf_field() !!}

                <div class="row">
                    <div class="form-group">
                        <div class="col-md-2 col-md-offset-1">
                            <label >{{__('admin_dossiers.db-client-name')}}</label>
                        </div>
                        <div class="col-md-8">
                            <input class="form-control" size="50" type="text"  value="{{$client->name.' - '.$client->surname}}" disabled/>
                            <input type="hidden" name="client_id" value="{{$client->id}}">
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="form-group">
                        <div class="col-md-2 col-md-offset-1">
                            <label for="name" >{{__('admin_dossiers.db-name')}}</label>
                        </div>
                        <div class="col-md-8">
                            <input class="form-control" size="50" type="text" name="name" value="{{old("name")}}" />
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group">
                        <div class="col-md-2 col-md-offset-1">
                            <label for="description" >{{__('admin_dossiers.db-description')}}</label>
                        </div>
                        <div class="col-md-8">
                            <input class="form-control" size="50" type="text" name="description" value="{{old("description")}}" />
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group" id="data_dossier">
                        <div class="col-md-2 col-md-offset-1">
                            <label for="date_dossier" ><i class="fa fa-calendar"></i> {{__('admin_dossiers.db-date_dossier')}}</label>
                        </div>
                        <div class="col-md-8 date">
                            <input class="form-control" type="text"  name="date_dossier" value="{{old("date_dossier")}}" />
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group">
                        <div class="col-md-2 col-md-offset-1">
                            <label for="note" >{{__('admin_dossiers.db-note')}}</label>
                        </div>
                        <div class="col-md-8">
                            <input class="form-control" size="50" type="text" name="note" value="{{old("note")}}" />
                        </div>
                    </div>
                </div>
                <br>
                <br>

                <div class="row">
                    <div class="col-md-12 text-center">
                        <p><button class="submit-toast btn btn-block btn-outline btn-primary" data-form-id="toast-form">{{__('admin_dossiers.submit')}}</button></p>
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>
@push('scripts')
<script>
$(function () {
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
@endpush


@endsection