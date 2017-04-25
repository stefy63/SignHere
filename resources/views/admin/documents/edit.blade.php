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
                <h5>{{__('admin_documents.edit-title')}}</h5>
                <div ibox-tools="" class="ng-scope">
                    <div dropdown="" class="ibox-tools dropdown">
                        <a href="{{ URL::previous() }}"><span class="badge badge-info"> <i class="fa fa-arrow-left"></i></span></a>
                    </div>
                </div>
            </div>
            <hr>

            <form method="POST" action="{{ route('admin_documents.update',['id' => $document->id]) }}" id="toast-form">
            {!! csrf_field() !!}{{ method_field('PUT') }}

                <div class="row">
                    <div class="form-group">
                        <div class="col-md-2 col-md-offset-1">
                            <label >{{__('admin_documents.db-client-name')}}</label>
                        </div>
                        <div class="col-md-8">
                            <input class="form-control" size="50" type="text"  value="{{$dossier->client->name.' - '.$dossier->client->surname}}" disabled/>
                            <input type="hidden" name="client_id" value="{{$dossier->client->id}}">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group">
                        <div class="col-md-2 col-md-offset-1">
                            <label >{{__('admin_documents.db-dossier-name')}}</label>
                        </div>
                        <div class="col-md-8">
                            <input class="form-control" size="50" type="text"  value="{{$dossier->name}}" disabled/>
                            <input type="hidden" name="dossier_id" value="{{$dossier->id}}">
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="form-group" id="date_doc">
                        <div class="col-md-2 col-md-offset-1">
                            <label for="date_doc" >{{__('admin_documents.db-date_doc')}}</label>
                        </div>
                        <div class="col-md-8 input-group date">
                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                            <input class="form-control" type="text"  name="date_doc" value="{{$document->date_doc}}" />
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group">
                        <div class="col-md-2 col-md-offset-1">
                            <label for="name" >{{__('admin_documents.db-name')}}</label>
                        </div>
                        <div class="col-md-8">
                            <input class="form-control" size="50" type="text" name="name" value="{{$document->name}}" />
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group">
                        <div class="col-md-2 col-md-offset-1">
                            <label for="identifier" >{{__('admin_documents.db-identifier')}}</label>
                        </div>
                        <div class="col-md-8">
                            <input class="form-control" size="50" type="text" name="identifier" value="{{$document->identifier}}" />
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group">
                        <div class="col-md-2 col-md-offset-1">
                            <label for="description" >{{__('admin_documents.db-description')}}</label>
                        </div>
                        <div class="col-md-8">
                            <input class="form-control" size="50" type="text" name="description" value="{{$document->description}}" />
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-2 col-md-offset-1">
                        <label for="doctype_id" >{{__('admin_documents.db-doctype')}}</label>
                    </div>
                    <div class="col-md-8">
                        <select class="form-control" name="doctype_id" id="select-doctype">
                            <option id="opt_doctype">{{__('admin_documents.select-doctype')}}</option>
                            @foreach($doctypes as $doctype)
                                <option value="{{$doctypes->id}}">{{$doctypes->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group">
                        <div class="col-md-2 col-md-offset-1">
                            <label for="signed" >{{__('admin_documents.db-signed')}}</label>
                        </div>
                        <div class="col-md-8">
                            <input class="js-switch-signed" type="checkbox" data-switchery="true" name="signed" value="1"  @if($document->signed == 1) checked @endif style="display: none;"/>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group">
                        <div class="col-md-2 col-md-offset-1">
                            <label for="readonly" >{{__('admin_documents.db-readonly')}}</label>
                        </div>
                        <div class="col-md-8">
                            <input class="js-switch-readonly" type="checkbox" data-switchery="true" name="readonly" value="1"  @if($document->readonly == 1) checked @endif style="display: none;"/>
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="form-group">
                        <div class="col-md-2 col-md-offset-1">
                            <label for="active" >{{__('admin_documents.db-active')}}</label>
                        </div>
                        <div class="col-md-8">
                            <input class="js-switch-active" type="checkbox" data-switchery="true" name="active" value="1"  @if($document->active == 1) checked @endif style="display: none;"/>
                        </div>
                    </div>
                </div>

                <br><br>

                <div class="row">
                    <div class="col-md-12 text-center">
                        <p><button class="submit-toast btn btn-block btn-outline btn-primary" data-form-id="toast-form">{{__('admin_documents.submit')}}</button></p>
                    </div>
                </div>
            </form>
            <br><br>

        </div>
    </div>

</div>
<script>
$(document).ready(function() {

    var elem = document.querySelector('.js-switch-signed');
    var switchery = new Switchery(elem, { color: '#1AB394' });

    var elem_2 = document.querySelector('.js-switch-readonly');
    var switchery_2 = new Switchery(elem_2, { color: '#1AB394' });

    var elem_3 = document.querySelector('.js-switch-active');
    var switchery_3 = new Switchery(elem_3, { color: '#1AB394' });



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
     $('#date_doc input').datepicker({
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