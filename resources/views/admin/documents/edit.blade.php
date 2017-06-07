@extends('admin.back')

@section('content')
@push('scripts')
<!-- Spinner -->
<script src="{{ asset('js/g-spinner.min.js') }}"></script>
@endpush
@push('assets')
<!-- Spinner -->
<link href="{{ asset('css/gspinner.min.css') }}" rel="stylesheet">
@endpush
<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>{{__('admin_documents.edit-title')}}</h5>
                <div ibox-tools="" class="ng-scope">
                    <div dropdown="" class="ibox-tools dropdown">
                        <a href="{{ url('admin_documents') }}"><button class="btn btn-primary dim"> <i class="fa fa-arrow-left"></i></button></a>
                    </div>
                </div>
            </div>
            <hr>

            <form method="POST" action="{{ route('admin_documents.update',['id' => $document->id]) }}" id="toast-form" enctype="multipart/form-data">
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
                            <select class="form-control" name="dossier_id" id="select-doctype">
                                @foreach($dossiers as $dos)
                                    <option value="{{$dos->id}}" @if($dos->id==$dossier->id) selected @endif>{{$dos->name}}</option>
                                @endforeach
                            </select>
                            <!--<input class="form-control" size="50" type="text"  value="{{$dossier->name}}" />
                            <input type="hidden" name="dossier_id" value="{{$dossier->id}}">-->
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="form-group" id="date_doc">
                        <div class="col-md-2 col-md-offset-1">
                            <label for="date_doc" ><i class="fa fa-calendar"></i> {{__('admin_documents.db-date_doc')}}</label>
                        </div>
                        <div class="col-md-8 date">
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
                                <option value="{{$doctype->id}}" @if($doctype->id==$document->doctype_id) selected @endif>{{$doctype->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!--<div class="row">
                    <div class="form-group">
                        <div class="col-md-2 col-md-offset-1">
                            <label for="signed" >{{__('admin_documents.db-signed')}}</label>
                        </div>
                        <div class="col-md-8">
                            <input class="js-switch-signed" type="checkbox" data-switchery="true" name="signed" value="1"  @if($document->signed == 1) checked @endif style="display: none;"/>
                        </div>
                    </div>
                </div>-->

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
                <br>

                <div class="row">
                    <div class="form-group">
                        <div class="col-md-2 col-md-offset-1">
                            <label for="filename" >{{__('admin_documents.db-filename')}}</label>
                        </div>
                        <div class="col-md-5">
                            <a href="{{ asset('storage')}}/documents/{{$document->filename}}" target="_blank">
                            <label class="form-control" >{{$document->filename}}</label></a>
                        </div>
                        <div class="col-md-3">
                            <input type="file" name="filename" accept=".pdf" />
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

<div id="showModal"></div>

<script>
$(document).ready(function() {

    var elem = document.querySelector('.js-switch-signed');
    var switchery = new Switchery(elem, { color: '#1AB394' });

    var elem_2 = document.querySelector('.js-switch-readonly');
    var switchery_2 = new Switchery(elem_2, { color: '#1AB394' });

    var elem_3 = document.querySelector('.js-switch-active');
    var switchery_3 = new Switchery(elem_3, { color: '#1AB394' });


     $('#date_doc input').datepicker({
        language: "it",
        todayBtn: "linked",
        keyboardNavigation: false,
        forceParse: false,
        calendarWeeks: false,
        autoclose: true
    });

     $('#toast-form').submit(function (e) {
        e.preventDefault();
        $('#showModal').modal({
            fadeDuration: 1000,
            escapeClose: false,
            clickClose: false,
            showClose: false,
            backdrop: "static"
        });
        var $loader = $("#showModal");
        $loader.gSpinner();
        $loader.css({
            'position': 'absolute',
            'top' : '20%',
            'left' : '30%',
            'zoom' : '2'
     });
        this.submit();
     });

})
</script>
@endsection