@extends('admin.back')

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
                    <option>{{__('admin_documents.select-acls')}}</option>
                    @foreach($acls as $acl)
                        <option value="{{$acl->id}}">{{$acl->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="ibox-content">
                <div class="col-md-4">
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
                        <table class="table table-stripped footable-odd"  id="tr-clients">
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
                                    <td>{{$clients->links()}}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <div class="col-md-8 border-left">
                    <div class="" style="height: 50%">
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
                            <table class="table table-stripped footable-odd" id="tr-dossier">
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
                    <div class="">
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
                            <table class="table table-stripped footable-odd" >
                                <tbody>
                                @foreach($documents as $document)
                                    <tr>
                                        <td>
                                            <a class="tab-document" id="{{$document->id}}">{{$document->name}}</a>
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
    $(document).on('mouseover','.tab-client',function(e){
        $(this).css('cursor', 'pointer');
    });
    $(document).on('mouseover','.tab-dossier',function(e){
        $(this).css('cursor', 'pointer');
    });

    $('#select-acl').on('change',function(e){
        e.preventDefault();
        var url = '{{url('admin_documents')}}';
        getData({
                _token: "{{csrf_token()}}",
                acl_id: this.value
        },url)
            .success(function(data){
                    $('#tr-clients').empty();
                    data[0].forEach(function(k){
                        console.log(k);
                        $('#tr-clients').append('<tr class="tab-client" id="'+k['id']+'"><td>'+k['name']+'</td></tr>');
                    });

            });
    });

    $(document).on('click','.tab-client',function(e){
        e.preventDefault();
        $('.tab-client').removeClass('bg-info');
        $(this).addClass('bg-info');
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
    });

    $(document).on('click','.tab-document',function(e){
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
            data: param,
            //success: function(data) {
                //console.log(data);
                /*if (data['success'])
                    toastr['success']('', data['success']);
                else {
                    toastr['warning']('', data['warning']);
                    setTimeout(function () {
                        location.reload();
                    }, 3000);
                }*/
                //retData(data) ;
           // },
           // error: function(error) {
                //location.reload();
          //  }
        });
    }

})

</script>

@endsection