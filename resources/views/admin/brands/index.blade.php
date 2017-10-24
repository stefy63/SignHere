@extends('admin.back')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>{{__('admin_brands.index-title')}}</h5>
                <div ibox-tools="" class="ng-scope">
                    <div dropdown="" class="ibox-tools dropdown">
                        <a href="{{ url('admin_brands/create') }}"><button class="btn btn-primary dim"> <i class="fa fa-plus"   data-toggle="tooltip" title="{{__('admin_brands.index-tooltip-create')}}"></i> {{__('admin_brands.index-new')}}</button></a>
                    </div>
                </div>
            </div>
            <div class="ibox-content">

                <div id="DataTables_Table_2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                    <!--<div class="row">
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
                    </div>-->
                    <div class="row">
                        <div class="col-sm-12">
                            <table class="table table-striped table-bordered table-hover dataTables-example ng-isolate-scope dataTable" datatable="" style="display: table;" id="DataTables_Table_2" role="grid" aria-describedby="DataTables_Table_2_info">
                                <thead>
                                    <tr role="row">
                                        <th class="col-md-1">{{__('admin_brands.index-header-col-0')}}</th>
                                        <th class="col-md-3">{{__('admin_brands.index-header-col-1')}}</th>
                                        <th class="col-md-1">{{__('admin_brands.index-header-col-2')}}</th>
                                        <th class="col-md-3">{{__('admin_brands.index-header-col-3')}}</th>
                                        <th class="col-md-2">{{__('admin_brands.index-header-col-4')}}</th>
                                        <th class="col-md-1">{{__('admin_brands.index-header-col-5')}}</th>
                                        <th class="col-md-1">{{__('admin_brands.index-header-col-6')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($brands as $brand)
                                    <tr class="gradeA odd" role="row">
                                        <td>
                                            <div class="onoffswitch" >
                                                <input type="checkbox" class="onoffswitch-checkbox" data-url="{{ route('admin_brands.update',['id' => $brand->id]) }}"  @if($brand->active == 1) checked @endif id="{{$brand->id}}">
                                                <label class="onoffswitch-label" for="{{$brand->id}}">
                                                    <span class="onoffswitch-inner"></span>
                                                    <span class="onoffswitch-switch"></span>
                                                </label>
                                            </div>
                                        </td>
                                        <td>
                                            <a class="open-modal" data-url="{{ url('admin_brands/'.$brand->id) }}" data-toggle="modal" data-target="#showModal" title="{{__('admin_brands.index-tooltip-col1')}}" >
                                                {{$brand->description}}
                                            </a>
                                        </td>
                                        <td>{{$brand->city}}</td>
                                        <td>{{$brand->address}}</td>
                                        <td>{{$brand->contact}}</td>
                                        <td>{{$brand->phone}}</td>
                                        <td class="text-center">
                                            <a href="{{ url('admin_brands/'.$brand->id.'/edit') }}" >
                                                <i class="fa fa-pencil"  data-toggle="tooltip" title="{{__('admin_brands.index-tooltip-update')}}"></i>
                                            </a>
                                            &nbsp;&nbsp;
                                            <a  class="confirm-toast"  data-message="{{__('admin_brands.index-confirm-message')}}"  data-location="{{ url('admin_brands/destroy/'.$brand->id) }}">
                                                <i class="fa fa-trash-o text-danger"  data-toggle="tooltip" title="{{__('admin_brands.index-tooltip-delete')}}"></i>
                                            </a>


                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                    <tr role="row">
                                        <th class="col-md-1">{{__('admin_brands.index-header-col-0')}}</th>
                                        <th>{{__('admin_brands.index-header-col-1')}}</th>
                                        <th>{{__('admin_brands.index-header-col-2')}}</th>
                                        <th>{{__('admin_brands.index-header-col-3')}}</th>
                                        <th>{{__('admin_brands.index-header-col-4')}}</th>
                                        <th>{{__('admin_brands.index-header-col-5')}}</th>
                                        <th class="col-md-1">{{__('admin_brands.index-header-col-6')}}</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-7">
                            <div class="dataTables_paginate paging_simple_numbers" id="DataTables_Table_2_paginate">
                                {{ $brands->links() }}
                            </div>
                        </div>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script>
    $(function () {

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
@endpush
@include('admin.brands.modal')

@endsection