@extends('admin.back')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>{{__('admin_clients.index-title')}}</h5>
                <div ibox-tools="" class="ng-scope">
                    <div dropdown="" class="ibox-tools dropdown">
                        <a href="{{ url('admin_clients/create') }}"> <i class="fa fa-plus-square-o"   data-toggle="tooltip" title="{{__('admin_clients.index-tooltip-create')}}"></i></a>
                    </div>
                </div>
            </div>
            <div class="ibox-content">

                <div id="DataTables_Table_2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="dataTables_length" id="DataTables_Table_2_length">
                                <label>Show
                                    <select name="DataTables_Table_2_length" aria-controls="DataTables_Table_2" class="form-control input-sm">
                                        <option value="10">10</option>
                                        <option value="25">25</option>
                                        <option value="50">50</option>
                                        <option value="100">100</option>
                                    </select> entries
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div id="DataTables_Table_2_filter" class="dataTables_filter">
                                <label>Search:
                                    <input type="search" class="form-control input-sm" placeholder="" aria-controls="DataTables_Table_2">
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <table class="table table-striped table-bordered table-hover dataTables-example ng-isolate-scope dataTable" datatable="" style="display: table;" id="DataTables_Table_2" role="grid" aria-describedby="DataTables_Table_2_info">
                                <thead>
                                    <tr role="row">
                                        <th class="col-md-1">{{__('admin_clients.index-header-col-0')}}</th>
                                        <th class="col-md-3">{{__('admin_clients.index-header-col-1')}}</th>
                                        <th class="col-md-1">{{__('admin_clients.index-header-col-2')}}</th>
                                        <th class="col-md-3">{{__('admin_clients.index-header-col-3')}}</th>
                                        <th class="col-md-2">{{__('admin_clients.index-header-col-4')}}</th>
                                        <th class="col-md-1">{{__('admin_clients.index-header-col-5')}}</th>
                                        <th class="col-md-1">{{__('admin_clients.index-header-col-6')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($clients as $client)
                                    <tr class="gradeA odd" role="row">
                                        <td>
                                            <div class="onoffswitch" >
                                                <input type="checkbox" class="onoffswitch-checkbox" data-url="{{ route('admin_clients.update',['id' => $client->id]) }}"  @if($client->active == 1) checked @endif id="{{$client->id}}">
                                                <label class="onoffswitch-label" for="{{$client->id}}">
                                                    <span class="onoffswitch-inner"></span>
                                                    <span class="onoffswitch-switch"></span>
                                                </label>
                                            </div>
                                        </td>
                                        <td>
                                            <a class="open-modal" data-url="{{ url('admin_clients/'.$client->id) }}" data-toggle="modal" data-target="#showModal" title="{{__('admin_clients.index-tooltip-col1')}}" >
                                                {{$client->surname}}&nbsp;{{$client->name}}
                                            </a>
                                        </td>
                                        <td>{{$client->surname}}</td>
                                        <td>{{$client->address}}</td>
                                        <td>{{$client->mobile}}</td>
                                        <td>{{$client->email}}</td>
                                        <td class="text-center">
                                            <a href="{{ url('admin_clients/'.$client->id.'/edit') }}" >
                                                <i class="fa fa-wrench"  data-toggle="tooltip" title="{{__('admin_clients.index-tooltip-update')}}"></i>
                                            </a>
                                            &nbsp;&nbsp;
                                            <a  class="confirm-toast"  data-message="{{__('admin_clients.index-confirm-message')}}"  data-location="{{ url('admin_clients/destroy/'.$client->id) }}">
                                                <i class="fa fa-trash"  data-toggle="tooltip" title="{{__('admin_clients.index-tooltip-delete')}}"></i>
                                            </a>


                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                    <tr role="row">
                                        <th class="col-md-1">{{__('admin_clients.index-header-col-0')}}</th>
                                        <th>{{__('admin_clients.index-header-col-1')}}</th>
                                        <th>{{__('admin_clients.index-header-col-2')}}</th>
                                        <th>{{__('admin_clients.index-header-col-3')}}</th>
                                        <th>{{__('admin_clients.index-header-col-4')}}</th>
                                        <th>{{__('admin_clients.index-header-col-5')}}</th>
                                        <th class="col-md-1">{{__('admin_clients.index-header-col-6')}}</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-7">
                            <div class="dataTables_paginate paging_simple_numbers" id="DataTables_Table_2_paginate">
                                {{ $clients->links() }}
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {

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
        
    })
    
</script>
@include('admin.clients.modal')

@endsection