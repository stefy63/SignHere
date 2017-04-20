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
                    <div class="" style="height: 40%;">
                        <div class="ibox-title">
                            <h5 class="text-danger">{{__('admin_documents.index-dossier')}}</h5>
                            <div ibox-tools="" class="ng-scope">
                                <div dropdown="" class="ibox-tools dropdown">
                                    <a href="{{ url('admin_dossiers/create') }}"><span class="badge badge-info"> <i class="fa fa-plus-square-o"   data-toggle="tooltip" title="{{__('admin_documents.index-tooltip-create')}}"></i></span></a>
                                </div>
                            </div>
                        </div>
                        <div class="">
                            <!-- DOSSIERS  -->
                            <table class="table table-bordered table-hover" id="tr-dossier">
                                <thead>
                                    <tr>
                                        <td></td>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($dossiers as $dossier)
                                    <tr class="tab-dossier" id="{{$dossier->id}}">
                                        <td>
                                           {{$dossier->name}}
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td>{{$dossiers->links()}}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <hr>
                    <div class="" style="height: 40%;">
                        <div class="ibox-title">
                            <h5 class="text-danger">{{__('admin_documents.index-document')}}</h5>
                            <div ibox-tools="" class="ng-scope">
                                <div dropdown="" class="ibox-tools dropdown">
                                    <a href="{{ url('admin_documents') }}"><span class="badge badge-info"> <i class="fa fa-plus-square-o"   data-toggle="tooltip" title="{{__('admin_documents.index-tooltip-create')}}"></i></span></a>
                                </div>
                            </div>
                        </div>
                        <div class="">
                            <!-- DOCUMENTS  -->
                            <table class="table table-bordered table-hover" id="tr-document">
                                <thead>
                                    <tr>
                                        <td></td>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($documents as $document)
                                    <tr class="tab-document" id="{{$document->id}}">
                                        <td>
                                            {{$document->name}}
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td>{{$documents->links()}}</td>
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
<script>
$(document).ready(function () {
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
                        console.log(k);
                        $('#tr-client').append('<tr class="tab-client" id="'+k['id']+'"><td>'+k['name']+'</td></tr>');
                    });

            });
    });

    $(document).on('click','.tab-client',function(e){
        e.preventDefault();
        $('.tab-client').removeClass('bg-success');
        $(this).addClass('bg-success');
        var url = '{{url('admin_documents')}}';
        getData({
                _token: "{{csrf_token()}}",
                client_id: this.id
        },url)
            .success(function(data){
                    $('#tr-dossier').empty();
                    data[0].forEach(function(k){
                        console.log(k);
                        $('#tr-dossier').append('<tr class="tab-dossier" id="'+k['id']+'"><td>'+k['name']+'</td></tr>');
                    });
            });
    });

    $(document).on('click','.tab-dossier',function(e){
        e.preventDefault();
        $('.tab-dossier').removeClass('bg-success');
        $(this).addClass('bg-success');
        console.log(this.id);
        var url = '{{url('admin_documents')}}';
        getData({
                _token: "{{csrf_token()}}",
            dossier_id: this.id
        },url)
            .success(function(data){
                    $('#tr-document').empty();
                    data[0].forEach(function(k){
                        console.log(k);
                        $('#tr-document').append('<tr class="tab-document" id="'+k['id']+'"><td>'+k['name']+'</td></tr>');
                    });
            });
    });

    $(document).on('click','.tab-document',function(e){
        e.preventDefault();
        $('.tab-document').removeClass('bg-danger');
        $(this).addClass('bg-danger');
        console.log(this.id);
    });

    $('.onoffswitch-checkbox').change(function (e) {
        e.preventDefault();
        var url = this.getAttribute('data-url');

        $.ajax({
            type: "PUT",
            url: url,
            data: {
                _token: "{{csrf_token()}}",
                active: $(this).is(':checked')?1:0
            },
            success: function(data){
                console.log(data);
                toastr['success']('', data['success']);
            }
        });
    });

    function getData(param,url,retData) {

        return $.ajax({
            type: "GET",
            url: url,
            data: param });
    }

})

</script>

@endsection