@extends('admin.back')
@push('scripts')
<!-- Data Table -->
<script src="{{ asset('js/plugins/dataTables/jquery.dataTables.js') }}"></script>
<script src="{{ asset('js/plugins/dataTables/dataTables.bootstrap.js') }}"></script>
<script src="{{ asset('js/plugins/dataTables/dataTables.responsive.js') }}"></script>
<script src="{{ asset('js/plugins/dataTables/dataTables.tableTools.min.js') }}"></script>
@endpush
@push('assets')
<!-- Data Table -->
<link href="{{ asset('css/plugins/dataTables/dataTables.bootstrap.css') }}" rel="stylesheet">
<link href="{{ asset('css/plugins/dataTables/dataTables.responsive.css') }}" rel="stylesheet">
<link href="{{ asset('css/plugins/dataTables/dataTables.tableTools.min.css') }}" rel="stylesheet">
@endpush
@section('content')
<div class="row" style="height: 100%">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>{{__('admin_documents.index-title')}}</h5>
                <!--<div ibox-tools="" class="ng-scope">
                    <div dropdown="" class="ibox-tools dropdown">
                        <a href="{{ url('admin_documents') }}"><span class="badge badge-info"> <i class="fa fa-plus-square-o"   data-toggle="tooltip" title="{{__('admin_documents.index-tooltip-create')}}"></i></span></a>
                    </div>
                </div>-->
            </div>
            <div class="ibox-heading">
                <select class="form-control" name="acl_id" id="select-acl">
                    <option id="opt_acl">{{__('admin_documents.select-acls')}}</option>
                    @foreach($acls as $acl)
                        <option value="{{$acl->id}}">{{$acl->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="ibox-content">
                <div class="col-md-5" style="height: 80%;">
                    <div class="ibox-title">
                        <h5 class="text-danger">{{__('admin_documents.index-client')}}</h5>
                        <div ibox-tools="" class="ng-scope">
                            <div dropdown="" class="ibox-tools dropdown">
                                <a href="{{ url('admin_clients/create') }}"><span class="badge badge-info"> <i class="fa fa-plus-square-o"   data-toggle="tooltip" title="{{__('admin_clients.index-tooltip-create')}}"></i></span></a>
                            </div>
                        </div>
                    </div>
                    <div class="">
                        <!-- CLIENTS  -->
                        <input type="hidden" id="client_id" value="0"/>
                        <table class="table table-bordered table-hover"  id="tr-client" cellspacing="0">
                            <thead>
                                <tr>
                                    <td></td>
                                </tr>
                            </thead>
                            <tbody class="tbody-client" >
                            @foreach($clients as $client)
                                <tr class="tab-client" id="{{$client->id}}">
                                    <td>
                                        {{$client->name}}
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <div class="col-md-7 border-left" style="height: 80%;">
                    <!-- DOSSIERS  -->
                    <div class="" style="height: 40%;">
                        <div class="ibox-title">
                            <h5 class="text-danger">{{__('admin_dossiers.index-dossier')}}</h5>
                            <div ibox-tools="" class="ng-scope">
                                <div dropdown="" class="ibox-tools dropdown">
                                    <a data-url="{{ url('admin_dossiers/create') }}" class="call-dossier"><span class="badge badge-info"> <i class="fa fa-plus-square-o"   data-toggle="tooltip" title="{{__('admin_dossiers.index-tooltip-dossier')}}"></i></span></a>
                                </div>
                            </div>
                        </div>
                        <div class="">
                            <input type="hidden" id="dossier_id" value="0" />
                            <table class="table table-bordered table-hover" id="tr-dossier">
                                <thead>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($dossiers as $dossier)
                                    <tr class="tab-dossier" id="{{$dossier->id}}">
                                        <td class="col-md-11">
                                           {{$dossier->name}}
                                        </td>
                                        <td class="text-center">
                                            <a class="tab-dossier_a OK-button"><i class="text-danger fa fa-trash-o"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <hr>
                    <!-- DOCUMENTS  -->
                    <div class="" style="height: 40%;">
                        <div class="ibox-title">
                            <h5 class="text-danger">{{__('admin_documents.index-document')}}</h5>
                            <div ibox-tools="" class="ng-scope">
                                <div dropdown="" class="ibox-tools dropdown">
                                    <a data-url="{{ url('admin_documents/create') }}" class="call-document"><span class="badge badge-info"> <i class="fa fa-plus-square-o"   data-toggle="tooltip" title="{{__('admin_documents.index-tooltip-document')}}"></i></span></a>
                                </div>
                            </div>
                        </div>
                        <div class="">
                            <input type="hidden" id="document_id" value="0"/>
                            <table class="table table-bordered table-hover" id="tr-document">
                                <thead>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($documents as $document)
                                    <tr class="tab-document" id="{{$document->id}}">
                                        <td class="col-md-11">
                                            {{$document->name}}
                                        </td>
                                        <td class=" text-center">
                                            <a class="tab-document_a OK-button"><i class="text-danger fa fa-trash-o"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td></td>
                                        <td></td>
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
        <div class="modal-content animated flipInY">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="modal-title" name="name"></h4>
            </div>
            <div class="modal-body">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function () {

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
        "searching": false,
        "pagingType": "numbers",
        "scrollY": "200px",
        "scrollCollapse": true
    };

    $('#tr-client').DataTable(tbl_option );
    $('#tr-dossier').DataTable(tbl_option );
    $('#tr-document').DataTable(tbl_option );

    $('#select-acl').on('change',function(e){
        e.preventDefault();
        $(this).children('#opt_acl').remove();
        var url = '{{url('admin_documents')}}';
        getData({
                _token: "{{csrf_token()}}",
                acl_id: this.value
        },url)
            .success(function(data){
                    $('#tr-client').empty();
                    data[0].forEach(function(k){
                        //console.log(k);
                        $('#tr-client').append('<tr class="tab-client" id="'+k['id']+'"><td>'+k['name']+'</td></tr>');
                    });

            });
    });


    $(document).on('dblclick','.tab-client',function(e){
        e.preventDefault();
        location.replace('{{ url('admin_clients/') }}/'+this.id+'/edit' );
    });

    $(document).on('dblclick','.tab-dossier',function(e){
        e.preventDefault();
        location.replace('{{ url('admin_dossiers/') }}/'+this.id+'/edit' );
    });

    $(document).on('dblclick','.tab-document',function(e){
        e.preventDefault();
        location.replace('{{ url('admin_documents/') }}/'+this.id+'/edit' );
        //toastr['error']('',"Funzione da implementare");
    });

    $(document).on('click','.tab-client',function(e){
        e.preventDefault();
        $('input#client_id').val(this.id);
        $('.tab-client').removeClass('bg-success');
        $(this).addClass('bg-success');
        getDossiers(this.id);
    });

    function getDossiers(client_id){
        var url = '{{url('admin_documents')}}';
        getData({
            _token: "{{csrf_token()}}",
            client_id: client_id
        },url).success(function(data){
            $('#tr-dossier').empty();
            data[0].forEach(function(k){
                //console.log(k);
                $('#tr-dossier').append('<tr class="tab-dossier" id="'+k['id']+'"><td class="col-md-11">'+k['name']+'</td>' +
                    '<td class=" text-center"><a class="tab-dossier_a OK-button"><i class="text-danger fa fa-trash-o"></i></a></td></tr>');
            });
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
        getData({
            _token: "{{csrf_token()}}",
            dossier_id: dossier_id
        },url).success(function(data){
            $('#tr-document').empty();
            data[0].forEach(function(k){
                //console.log(k);
                $('#tr-document').append('<tr class="tab-document" id="'+k['id']+'"><td class="col-md-11">'+k['name']+'</td>' +
                    '<td class=" text-center"><a class="tab-document_a OK-button"><i class="text-danger fa fa-trash-o"></i></a></td></tr>');
            });
        });
    }

    $(document).on('click','.tab-dossier_a',function(e){
        e.stopPropagation();
        var dossier = $(this).closest('tr').attr('id');
        console.log(dossier);
        var url = '{{url('admin_dossiers/destroy')}}/'+dossier;
        swal({
            title: '{{__('app.confirm-title')}}',
            text: '{{__('app.confirm-message')}}',
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes",
            closeOnConfirm: true
        }, function (isConfirm) {
            if(isConfirm) {
                getData({
                    _token: "{{csrf_token()}}",
                },url).success(function (data) {
                    toastr['success']('',data[0]);
                    getDossiers($('input#client_id').val());
                }).error(function (xhr, status, err) {
                    console.log(JSON.parse(xhr.responseText)[0]);
                    toastr['error']('',JSON.parse(xhr.responseText)[0]);
                });
            }
        });
    });

    $(document).on('click','.tab-document',function(e){
        e.preventDefault();
        $('input #document_id').val(this.id);
        $('.tab-document').removeClass('bg-danger');
        $(this).addClass('bg-danger');
        console.log(this.id);
    });

    $(document).on('click','.tab-document_a',function(e){
        e.stopPropagation();
        var dossier = $(this).closest('tr').attr('id');
        alert(dossier);
    });

    function getData(param,url) {

        return $.ajax({
            type: "GET",
            url: url,
            data: param });
    }

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

@endsection