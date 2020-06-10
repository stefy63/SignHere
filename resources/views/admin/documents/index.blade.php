@extends('admin.back')
@push('scripts')
<!-- Data Table -->
<script src="{{ asset('js/plugins/dataTables/jquery.dataTables.js') }}"></script>
<script src="{{ asset('js/plugins/dataTables/dataTables.bootstrap.js') }}"></script>
<script src="{{ asset('js/plugins/dataTables/dataTables.responsive.js') }}"></script>
<script src="{{ asset('js/plugins/dataTables/dataTables.tableTools.min.js') }}"></script>
<!-- DROPZONE -->
<script src="{{ asset('js/plugins/dropzone/dropzone.js') }}"></script>
<script>
$(function () {
    Dropzone.options.myAwesomeDropzone = {
        acceptedFiles: "application/pdf",
        //autoProcessQueue: false,
        uploadMultiple: true,
        maxFiles: 1,
        maxFilesize: 2,
        paramName: 'documents',
        //autoQueue: false,
        dictInvalidFileType: '{{__('admin_documents.notify_alert_type')}}',
        dictFileTooBig: '{{__('admin_documents.notify_alert_toobigfile')}}',
        dictMaxFilesExceeded:'{{__('admin_documents.notify_alert_multiple', ['max' => '1'])}}',

        init: function() {
            this.on("success", function(files, response) {
                toastr['success']("{{ session('success') }}", response.message1.veicleSummary[0]);
                var result = response.message1;
                var html = '<form method="POST" action="{{ route('admin_dossiers.update_import_file') }}" id="toast-form" enctype="multipart/form-data">{!! csrf_field() !!}';
                for(var val in result){
                    html += '<div class="col-md-12 row"><div class="form-group group'+((result[val][2] == 100)?' hide':'')+'">'+
                            '<div class="col-md-4"><label for="date_doc" >'+result[val][1]+'</label></div>'+
                            '<div class="col-md-8"><input class="form-control" type="text"  name="'+val+'" value="'+result[val][0]+'"/></div>' +
                            '</div></div>';
                }
                html += '<div class="col-md-12 row"><div class="form-group group">'+
                            '<div class="col-md-4"><label for="venditore" >Venditore</label></div>'+
                            '<div class="col-md-8"><input class="form-control" type="text"  name="venditore" value="{{Auth::user()->name . ' ' . Auth::user()->surname}}"/></div>' +
                            '</div></div>';

                html += '<div class="col-md-12 row"><div class="form-group group">' +
                            '<div class="col-md-4"><label for="incentivo" >Sconto/Incentivo</label></div>' +
                            '<div class="col-md-8"><input class="form-control" type="text"  name="incentivo" value=" " /></div>' +
                            '</div></div>';

                html += '<div class="col-md-12 row"><div class="form-group group">'+
                            '<div class="col-md-4"><label for="note" >Note</label></div>'+
                            '<div class="col-md-8"><input class="form-control" type="text"  name="note" value=" " /></div>' +
                            '</div></div>';


                html += '<div class="row footer-group"><br>' +
                    '<div class="col-md-12 text-center footer-group">' +
                    '<p><button class="submit-toast btn btn-outline btn-primary col-md-6" data-form-id="toast-form">{{__('admin_documents.submit')}}</button>' +
                    '<button class="btn btn-outline btn-danger col-md-6" type="reset" onclick="cancelForm()">{{__('admin_documents.cancel_form')}}</button></p>' +
                    '</div></div></form>';
                $('#modal-content div').html(html);
            });
            this.on("maxfilesexceeded", function(files, response) {
                toastr['error']("{{ session('alert') }}", "{{__('admin_documents.notify_alert_multiple')}}");
            });
            this.on("error", function(files, response) {
                $retMsg = (response.message)?response.message:"{{__('admin_documents.notify_alert')}}";
                toastr['error']("{{ session('alert') }}", $retMsg);
            });
            this.on("complete", function(file) {
                this.removeFile(file);
                // $('#showModal').modal('hide');
                // $('.modal-backdrop').remove();
            });
        }
    };



});

function cancelForm() {
    $('#showModal').modal('hide');
    location.reload();
};

</script>

@endpush
@push('assets')
<style>
    .footer-group {
        margin-top: 10px;
    }
    .group label {
        margin-bottom: 1px;
        font-size: 11px;
    }
    .group input {
        height: 20px;
        font-size: 10px;
    }

    .filter-container {
        position: relative;
    }

    .filter-container .clear_filter {
        color: lightskyblue;
        font-size: 20px;
        position: absolute;
        right: -10px;
        top: -5px;
        display: none;
    }
</style>
<!-- Data Table -->
<link href="{{ asset('css/plugins/dataTables/dataTables.bootstrap.css') }}" rel="stylesheet">
<link href="{{ asset('css/plugins/dataTables/dataTables.responsive.css') }}" rel="stylesheet">
<link href="{{ asset('css/plugins/dataTables/dataTables.tableTools.min.css') }}" rel="stylesheet">
<!-- Dropzone -->
<link href="{{ asset('css/plugins/dropzone/basic.css') }}" rel="stylesheet">
<link href="{{ asset('css/plugins/dropzone/dropzone.css') }}" rel="stylesheet">
@endpush
@section('content')
<div class="row" style="height: 100%">
    <div class="col-lg-12 col-md-12 col-xs-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>{{__('admin_documents.index-title')}}</h5>
                <div ibox-tools="" class="ng-scope">
                    <div dropdown="" class="ibox-tools dropdown">
                        @if(Auth::user()->hasRole('admin_documents','import'))
                        <a class="open-modal" data-toggle="modal" data-target="#showModal" title="{{__('admin_documents.index-tooltip-upload')}}" >
                            <button class="btn btn-white"> <i class="fa fa-upload" data-toggle="tooltip" title="{{__('admin_documents.index-tooltip-upload')}}"></i> {{__('admin_documents.index-upload')}}</button>
                        </a>
                        @endif
                    </div>
                </div>
            </div>
            <div class="ibox-heading">
                <select class="form-control" name="acl_id" id="select-acl">
                    <option id="opt_acl" value="0">{{__('admin_documents.select-acls')}}</option>
                    @foreach($acls as $acl)
                        <option value="{{$acl->id}}" @if($acl->id == $acl_id)
                          selected
                        @endif>{{$acl->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="ibox-content">
                <div class="col-lg-6 col-md-6 col-xs-6" style="height: 80%;" id="div-client">
                    <div class="ibox-title">
                        <h5 class="text-danger">{{__('admin_documents.index-client')}}</h5>
                        <div ibox-tools="" class="ng-scope">
                            <div dropdown="" class="ibox-tools dropdown">
                                @if(Auth::user()->hasRole('admin_clients','create'))
                                <a href="{{ url('admin_clients/create') }}"><button class="btn btn-primary dim"> <i class="fa fa-plus"   data-toggle="tooltip" title="{{__('admin_clientsindex-tooltip-create')}}"></i> {{__('admin_brands.index-new')}}</button></a>
                                @endif
                            </div>
                        </div>
                    </div>
                    <section class=" col-lg-12 col-md-12 col-xs-12">
                        <div class="filter-container" >
                            <input type="search" class="form-control input-sm" data-section-name="client" data-location="{{url('admin_documents')}}" value="{{$clientfilter}}"  placeholder="Search..." data-name="clientfilter" />
                            <button class="clear_filter btn btn-link">
                                <i class="fa fa-times-circle-o"></i>
                            </button>
                        </div>
                        <div class="client">
                            @include('admin.documents.client')
                        </div>
                    </section>
                </div>
                <div class="col-lg-6 col-md-6 col-xs-6 border-left">
                    <div class="col-lg-12 col-md-12 col-xs-12" style="height: 40%;" id="div-dossier" hidden>
                        <div class="ibox-title">
                            <h5 class="text-danger">{{__('admin_dossiers.index-dossier')}}</h5>
                            <div ibox-tools="" class="ng-scope">
                                <div dropdown="" class="ibox-tools dropdown">
                                    @if(Auth::user()->hasRole('admin_documents','create'))
                                    <a data-url="{{ url('admin_dossiers/create') }}" class="call-dossier"><button class="btn btn-primary dim"> <i class="fa fa-plus"   data-toggle="tooltip" title="{{__('admin_dossiers.index-tooltip-dossier')}}"></i> {{__('admin_brands.index-new')}}</button></a>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="filter-container">
                            <input type="search" class="form-control input-sm" data-section-name="dossier" data-location="{{url('admin_documents')}}" value="{{$dossierfilter}}"  placeholder="Search..." data-name="dossierfilter" />
                            <button class="clear_filter btn btn-link">
                                <i class="fa fa-times-circle-o"></i>
                            </button>
                        </div>
                        <section class="dossier" >
                            @include('admin.documents.dossier')
                        </section>
                    </div>
                    <hr>
                    <div class="col-lg-12 col-md-12 col-xs-12" style="height: 40%;"  id="div-documents" hidden>
                        <div class="ibox-title">
                            <h5 class="text-danger">{{__('admin_documents.index-document')}}</h5>
                            <div ibox-tools="" class="ng-scope">
                                <div dropdown="" class="ibox-tools dropdown">
                                    @if(Auth::user()->hasRole('admin_documents','create'))
                                    <a data-url="{{ url('admin_documents/create') }}" class="call-document"><button class="btn btn-primary dim"> <i class="fa fa-plus"   data-toggle="tooltip" title="{{__('admin_documents.index-tooltip-document')}}"></i> {{__('admin_brands.index-new')}}</button></a>
                                    @endif
                                </div>
                            </div>
                        </div>
                         <section class="documents">
                            @include('admin.documents.document')
                        </section>
                     </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<div class="modal inmodal" id="showModal" tabindex="-1"  role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated fadeInDown" id="modal-content">
            <div class="modal-body">
                <form id="my-awesome-dropzone" class="dropzone" action="{{ route('admin_dossiers.import_file') }}" enctype="multipart/form-data">
                    {!! csrf_field() !!}{{ method_field('POST') }}
                    <div class="dz-message text-center m-t-lg"><span><h1>{{__('admin_documents.drop_file')}}</h1></span></div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
$(function () {

  var timer;

    $(document).on('click','.href',function(e){
        e.stopPropagation();
        var location =  this.getAttribute('data-url');

        window.location = location;
    });


    $('.call-dossier').click(function(e){
        e.stopPropagation();
        var client_id = $('input#client_id').val();
        if(client_id != 0){
            var url = this.getAttribute('data-url');
            url += '?client_id='+client_id;
            location.replace(url);
        } else {
            toastr['error']("{{__('admin_documents.error_dossier')}}", "{{__('admin_documents.error_call_title')}}");
        }

    });

    $('.call-document').click(function(e){
        e.stopPropagation();
        var dossier_id = $('input#dossier_id').val();
        if(dossier_id != 0){
            var url = this.getAttribute('data-url');
            url += '?dossier_id='+dossier_id;
            location.replace(url);
        } else {
            toastr['error']("{{__('admin_documents.error_document')}}", "{{__('admin_documents.error_call_title')}}");
        }
    });


    $('#select-acl').on('change',function(e){
        e.stopPropagation();
        $('#div-documents').hide();
        $('#div-dossier').hide();
        var url = '{{url('admin_documents')}}';

        $.ajax({
            type: "GET",
            url: url,
            data: {
                _token: "{{csrf_token()}}",
                acl_id: this.value
            } })
            .done(function(data){
                $('.client').html(data);
            });
    });

    $(document).on('click','.tab-client',function(e){
        e.stopPropagation();
        $('#div-documents').hide();
        $('#div-dossier').hide();
        $('input#client_id').val(this.id);
        $('.tab-client').removeClass('bg-success');
        $(this).addClass('bg-success');
        $('#div-dossier').find('input[type=search]').val('');
        // getDossiers(this.id);
        getAjaxFilter($('#div-dossier').find('input[type=search]'));
    });

    function getDossiers(client_id){
        var url = '{{url('admin_documents')}}';

        $.ajax({
            type: "GET",
            url: url,
            data: {
                _token: "{{csrf_token()}}",
                client_id: client_id
            } }).done(function(data){
                $('.dossier').html(data);
                $('#div-dossier').show();
                $('#tr-dossier #{{$dossier_id}}').addClass('bg-success');
        });
    }

    $(document).on('click','.tab-dossier',function(e){
        e.stopPropagation();
        $('.dossier #dossier_id').val(this.id);
        $('.tab-dossier').removeClass('bg-success');
        $(this).addClass('bg-success');
        getDocuments(this.id);
    });

    function getDocuments(dossier_id){
        var url = '{{url('admin_documents')}}';

        $.ajax({
            type: "GET",
            url: url,
            data: {
                _token: "{{csrf_token()}}",
                dossier_id: dossier_id
            } }).done(function(data){
                $('.documents').html(data);
                $('#div-documents').show();
        });
    }

    $(document).on('click','.tab-dossier_a',function(e){
        e.stopPropagation();
        var dossier = $(this).closest('tr').attr('id');
        var url = '{{url('admin_dossiers/destroy')}}/'+dossier;
        swal({
            title: '{{__('app.confirm-title')}}',
            text: '{{__('app.confirm-message')}}',
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes",
        }, function (isConfirm) {
            if(isConfirm) {
                $.ajax({
                    type: "GET",
                    url: url,
                    data: {
                        _token: "{{csrf_token()}}",
                    }
                })
                .done(function (data) {
                    getDossiers($('input#client_id').val());
                    swal("Deleted!", data[0], "success");
                })
                .error(function (xhr, status, err) {
                    swal("Error!", JSON.parse(xhr.responseText)[0], "error");
                    toastr['error']('',JSON.parse(xhr.responseText)[0]);
                });
            } else {
                swal("Cancel!","{{__('admin_dossiers.abort_document_deleted')}}", "error");
            }
        });
    });


    $(document).on('click','.tab-document_a',function(e){
      e.stopPropagation();
        var document = $(this).closest('tr').attr('id');
        ///alert(document);
        var url = '{{url('admin_documents/destroy')}}/'+document;
        swal({
            title: '{{__('app.confirm-title')}}',
            text: '{{__('app.confirm-message')}}',
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes",
        }, function (isConfirm) {
            if(isConfirm) {
                $.ajax({
                    type: "GET",
                    url: url,
                    data: {
                        _token: "{{csrf_token()}}",
                    }
                })
                .done(function (data) {
                    getDocuments($('input#dossier_id').val());
                    swal("Deleted!", data[0], "success");
                })
                .error(function (xhr, status, err) {
                    swal("Error!", JSON.parse(xhr.responseText)[0], "error");
                    toastr['error']('',JSON.parse(xhr.responseText)[0]);
                });
            } else {
                swal("Abort!", "{{__('admin_documents.abort_document_deleted')}}", "error");
            }
        });
    });

    function OKButton() {
        swal({
            title: '{{__('app.confirm-title')}}',
            text: '{{__('app.confirm-message')}}',
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes",
            closeOnConfirm: true
        }, function (isConfirm) {
            return isConfirm;
        });
    };

    $(document).on('click','.sendmail', function(e){
        e.stopPropagation();
        var location =  this.getAttribute('data-location');
        swal({
            title: '{{__('app.confirm-title')}}',
            text: this.getAttribute('data-message'),
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes",
            closeOnConfirm: true
        }, function () {
            window.location.replace(location)
        });
    });

    $(document).on('keyup', 'input[type=search]', function (e) {
        e.stopPropagation();
        clearTimeout(timer);
        setShowBtnClearFilter(this);
        if ($(this).val().length > 3) {
            timer = setTimeout(() => {
                clearTimeout(timer);
                getAjaxFilter(this);
            }, 2000);
        }
        if( e.which == 13) {
            clearTimeout(timer);
            getAjaxFilter(this);
        }
    });

    function setShowBtnClearFilter(obj) {
        if($(obj).val().length > 0) {
            $(obj).parent().find('.clear_filter').show();
        } else {
            $(obj).parent().find('.clear_filter').hide();
        }
    }

    $('.clear_filter').click(function(e){
        e.stopPropagation();
        $(this).parent().find('input[type=search]').val('');
        clearTimeout(timer);
        getAjaxFilter($(this).parent().find('input[type=search]'));
    });

    function getAjaxFilter(obj) {
        $('#div-documents').hide();
        $('#div-dossier').hide();

        var dataObj = {
            '_token': "{{csrf_token()}}",
            'client_id': $('input#client_id').val() || 0,
        };
        dataObj[$(obj).attr('data-name')] = $(obj).val() ?  $(obj).val() : '#';
        var section = $(obj).attr('data-section-name');

        $.ajax({
          type: "GET",
          data: dataObj,
          }).done(function(data){
              $('.'+section).html(data);
              $('#div-'+section).show();
              setShowBtnClearFilter(obj);

          });
    }

  if('{{$clientfilter}}' != '') {
    setShowBtnClearFilter($('#div-client').find('input[type=search]'));
  }
  if('{{$dossierfilter}}' != '') {
    $('#div-dossier input[type=search]').val({{$dossierfilter}});
    setShowBtnClearFilter($('#div-dossier').find('input[type=search]'));
  }

  if({{$client_id}} != 0) {
    $('#div-documents').hide();
    $('#div-dossier').hide();
    $('input#client_id').val({{$client_id}});
    $('.tab-client').removeClass('bg-success');
    $('#tr-client #{{$client_id}}').addClass('bg-success');
    getDossiers({{$client_id}});
  }

  if({{$dossier_id}} != 0) {
    $('.dossier #dossier_id').val({{$dossier_id}});
    $('.tab-dossier').removeClass('bg-success');
    $('#tr-dossier #{{$dossier_id}}').addClass('bg-success');
    getDocuments({{$dossier_id}});
  }


})

</script>
@endpush
@endsection
