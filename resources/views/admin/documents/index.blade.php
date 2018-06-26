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
                        <option value="{{$acl->id}}">{{$acl->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="ibox-content">
                <div class="col-lg-6 col-md-6 col-xs-6" style="height: 80%;">
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
                    <div class=" col-lg-12 col-md-12 col-xs-12">
                        <!-- CLIENTS  -->
                        <input type="hidden" id="client_id" value="0"/>
                        <table class="table table-bordered table-hover" id="tr-client" cellspacing="0">
                            <thead>
                                <tr>
                                    <th class="col-lg-12 col-md-12 col-xs-12"></th>
                                </tr>
                            </thead>
                            <tbody class="tbody-client" >
                            @foreach($clients as $client)
                                <tr class="tab-client"  id="{{$client->id}}">
                                    <td>
                                        <i class="fa fa-user"></i>&nbsp;&nbsp; {{$client->surname}} {{$client->name}}
                                        @if(Auth::user()->hasRole('admin_clients','edit'))
                                        <a data-url="{{ url('admin_clients/')}}/{{$client->id}}/edit" class="href"><i class="fa fa-pencil pull-right"></i></a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-xs-6 border-left">
                    <!-- DOSSIERS  -->
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
                        <input type="hidden" id="dossier_id" value="0" />
                        <table class="table table-bordered table-hover" id="tr-dossier">
                            <thead>
                                <tr>
                                    <th class="col-lg-10 col-md-10 col-xs-10"></th>
                                    <th class="col-lg-2 col-md-2 col-xs-2"></th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($dossiers as $dossier)
                                <tr class="tab-dossier" id="{{$dossier->id}}">
                                    <td>
                                       <i class="fa fa-archive"></i> {{$dossier->name}}
                                    </td>
                                    <td class="text-center">
                                        @if(Auth::user()->hasRole('admin_documents','edit'))<a data-url="{{ url('admin_dossiers/')}}/{{$dossier->id}}/edit" class="href"><i class="fa fa-pencil"></i></a>@endif
                                        @if(Auth::user()->hasRole('admin_documents','export'))<a data-url="{{ url('admin_dossiers/export/'.$dossier->id)}}" class="href text-warning text-center"><i class="fa fa-file-excel-o"></i></a>@endif
                                        @if(Auth::user()->hasRole('admin_documents','destroy'))<a class="tab-dossier_a OK-button"><i class="text-danger fa fa-trash-o"></i></a>@endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th class="col-lg-10 col-md-10 col-xs-10"></th>
                                    <th class="col-lg-2 col-md-2 col-xs-2"></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <hr>
                    <!-- DOCUMENTS  -->
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
                        <div class="">
                            <input type="hidden" id="document_id" value="0"/>
                            <table class="table table-bordered table-hover" id="tr-document">
                                <thead>
                                    <tr>
                                        <th class="col-lg-1 col-md-1 col-xs-1"></th>
                                        <th class="col-lg-9 col-md-9 col-xs-9"></th>
                                        <th class="col-lg-2 col-md-2 col-xs-2"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($documents as $document)
                                    <tr id="{{$document->id}}">
                                        <td>
                                            @if(Auth::user()->hasRole('admin_documents','download'))<a href="{{ asset('storage')}}/documents/{{$document->filename}}" target="_blank"><i class="fa fa-download"></i></a> @endif
                                        </td>
                                        <td class="@if($document->signed) text-line-through text-danger @endif" id="{{$document->id}}">
                                            {{$document->name}}
                                        </td>
                                        <td>
                                            @if(Auth::user()->hasRole('admin_documents','edit'))<a data-url="{{ url('admin_documents/')}}/{{$document->id}}/edit" class="href"><i class="fa fa-pencil"></i></a>@endif
                                            @if(Auth::user()->hasRole('admin_documents','destroy'))<a class="tab-document_a OK-button"><i class="text-danger fa fa-trash-o"></i></a>@endif
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th class="col-lg-1 col-md-1 col-xs-1"></th>
                                        <th class="col-lg-9 col-md-9 col-xs-9"></th>
                                        <th class="col-lg-2 col-md-2 col-xs-2"></th>
                                    </tr>
                                </tfoot>
                            </table>
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
    // $.fn.dataTable.ext.search.push(
    // function( settings, data, dataIndex ) {
    //     console.log(settings, data, dataIndex);
    // });

    $(document).on('click','.href',function(e){
        e.preventDefault();
        var location =  this.getAttribute('data-url');
        console.log(location);

        window.location = location;
    });


    $('.call-dossier').click(function(e){
        e.preventDefault();
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
        e.preventDefault();
        var dossier_id = $('input#dossier_id').val();
        if(dossier_id != 0){
            var url = this.getAttribute('data-url');
            url += '?dossier_id='+dossier_id;
            location.replace(url);
        } else {
            toastr['error']("{{__('admin_documents.error_document')}}", "{{__('admin_documents.error_call_title')}}");
        }
    });

    var tbl_option = {
        "paging": true,
        "ordering": false,
        "info": false,
        "searching": true,
        "pagingType": "numbers",
        //"scrollY": "auto",
        "scrollCollapse": true
    };

    $('#tr-client').DataTable(tbl_option );
    $('#tr-dossier').DataTable(tbl_option );
    $('#tr-document').DataTable(tbl_option );

    $('#select-acl').on('change',function(e){
        e.preventDefault();
        $('#div-documents').hide();
        $('#div-dossier').hide();
        //$('#tr-dossier').hide();
        //$(this).children('#opt_acl').remove();
        var url = '{{url('admin_documents')}}';

        $.ajax({
            type: "GET",
            url: url,
            data: {
                _token: "{{csrf_token()}}",
                acl_id: this.value
            } })
            .done(function(data){
                var t = $('#tr-client').DataTable();
                t.clear().draw();
                data[0].forEach(function(k){
                    var row = '<td><i class="fa fa-user"></i>&nbsp;&nbsp;'+k['name']+' '+((k['surname'])?k['surname']:'');
                    @if(Auth::user()->hasRole('admin_clients','edit')) row += '<a  data-url="{{ url('admin_clients/')}}'+'/'+k['id']+'/edit" class="href"><i class="fa fa-pencil pull-right"></i></a>';  @endif
                    row += '</td>';
                    var node = t.row.add([row]).draw().node();
                    $(node).addClass('tab-client').attr('id', k['id']);
                });
                $('#tr-dossier').show();
            });
    });

    $(document).on('click','.tab-client',function(e){
        e.preventDefault();
        $('#div-documents').hide();
        $('#div-dossier').hide();
        $('input#client_id').val(this.id);
        $('.tab-client').removeClass('bg-success');
        $(this).addClass('bg-success');
        getDossiers(this.id);
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
            $('#tr-dossier tbody').empty();
            var t = $('#tr-dossier').DataTable();
            t.clear().draw();
            data[0].forEach(function(k){
                var row = [];
                row[0] = '<td><i class="fa fa-archive"></i> '+k['name']+'</td>';
                row[1] = '<td class="text-center">';
                @if(Auth::user()->hasRole('admin_documents','edit'))
                row[1] += '<a data-url="{{ url('admin_dossiers/')}}/'+k['id']+'/edit" class="href pull-left"><i class="fa fa-pencil"></i></a>&nbsp&nbsp';
                @endif
                @if(Auth::user()->hasRole('admin_documents','export'))
                row[1] += '<a data-url="{{ url('admin_dossiers/export/')}}/'+k['id']+'" class="href text-warning text-center"><i class="fa fa-file-excel-o"></i></a>';
                @endif
                @if(Auth::user()->hasRole('admin_documents','destroy'))
                row[1] += '<a class="tab-dossier_a OK-button"><i class="text-danger fa fa-trash-o pull-right"></i></a>';
                @endif
                row[1] += '</td>';
                var node = t.row.add(row).draw().node();
                $(node).addClass('tab-dossier').attr('id', k['id']);
            });
            $('#div-dossier').show();
        });
    }

    $(document).on('click','.tab-dossier',function(e){
        e.preventDefault();
        $('input#dossier_id').val(this.id);
        $('.tab-dossier').removeClass('bg-success');
        $(this).addClass('bg-success');
        console.log(this.id);
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
            $('#tr-document tbody').empty();
            var t = $('#tr-document').DataTable();
            t.clear().draw();
            data[0].forEach(function(k){
                var row = [];
                row[0] = '<td>';
                {{--@if(Auth::user()->hasRole('admin_documents','download'))--}}
                    row[0] += '<td><a href="{{ asset('storage')}}/documents/'+k['filename']+'" target="_blank"><i class="fa fa-download"></i></a>';
                {{--@endif--}}
                row[0] += '</td>';
                row[1] = '<td class=" "><i ';
                row[1] += (k['signed'] == 1)?'class="fa fa-check-square-o" style="color: green;"':'class="fa fa fa-minus-square-o" style="color: red;"';
                row[1] += '></i>  '+k['name']+'</td>';
                row[2] = '<td>';
                @if(Auth::user()->hasRole('admin_documents','edit'))
                    row[2] += '<a data-url="{{ url('admin_documents/')}}/'+k['id']+'/edit" class="href pull-left"><i class="fa fa-pencil"></i></a>';
                @endif
                @if(Auth::user()->hasRole('admin_documents','destroy'))
                    row[2] += '<a class="tab-document_a OK-button"><i class="text-danger fa fa-trash-o pull-right"></i></a>';
                @endif
                row[2] += '</td>'

                var node = t.row.add(row).draw().node();
                $(node).attr('id', k['id']).attr('data-toggle', 'tooltip').attr('title', k['date_sign']);
            });
            $('#div-documents').show();
        });
    }

    $(document).on('click','.tab-dossier_a',function(e){
        var dossier = $(this).closest('tr').attr('id');
        //console.log(dossier);
        var url = '{{url('admin_dossiers/destroy')}}/'+dossier;
        swal({
            title: '{{__('app.confirm-title')}}',
            text: '{{__('app.confirm-message')}}',
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes",
            closeOnConfirm: false,
            closeOnCancel: false
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
                    //toastr['success']('',data[0]);
                    getDossiers($('input#client_id').val());
                    swal("Deleted!", data[0], "success");
                })
                .error(function (xhr, status, err) {
                    console.log(JSON.parse(xhr.responseText)[0]);
                    swal("Error!", JSON.parse(xhr.responseText)[0], "error");
                    toastr['error']('',JSON.parse(xhr.responseText)[0]);
                });
            } else {
                swal("Cancel!","{{__('admin_dossiers.abort_document_deleted')}}", "error");
            }
        });
    });

    $(document).on('click','.tab-document',function(e){
       /* e.preventDefault();
        var document = $(this).closest('tr').attr('id');
        $('input #document_id').val(document);
        $(this).closest('tbody').find('tr').removeClass('bg-danger');
        $(this).closest('tr').addClass('bg-danger');
        console.log(document);
        //alert(document);*/

    });

    $(document).on('click','.tab-document_a',function(e){
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
            closeOnConfirm: false,
            closeOnCancel: false
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
                    console.log(JSON.parse(xhr.responseText)[0]);
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
            console.log(isConfirm);
            return isConfirm;
        });
    };

})

</script>
@endpush
@endsection