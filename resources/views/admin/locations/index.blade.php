@extends('admin.back')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>{{__('admin_locations.index-title')}}</h5>
                <div ibox-tools="" class="ng-scope">
                    <div dropdown="" class="ibox-tools dropdown">
                        @if(Auth::user()->hasRole('admin_locations','create'))
                        <a href="{{ url('admin_locations/create') }}"><button class="btn btn-primary dim"> <i class="fa fa-plus"   data-toggle="tooltip" title="{{__('admin_locationsindex-tooltip-create')}}"></i> {{__('admin_brands.index-new')}}</button></a>
                        @endif
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
                                        <th class="col-md-1">{{__('admin_locations.index-header-col-0')}}</th>
                                        <th class="col-md-2">{{__('admin_locations.index-header-col-7')}}</th>
                                        <th class="col-md-2">{{__('admin_locations.index-header-col-1')}}</th>
                                        <th class="col-md-1">{{__('admin_locations.index-header-col-2')}}</th>
                                        <th class="col-md-2">{{__('admin_locations.index-header-col-3')}}</th>
                                        <th class="col-md-2">{{__('admin_locations.index-header-col-4')}}</th>
                                        <th class="col-md-1">{{__('admin_locations.index-header-col-5')}}</th>
                                        <th class="col-md-1">{{__('admin_locations.index-header-col-6')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($locations as $location)
                                    <tr class="gradeA odd" role="row">
                                        <td>
                                            <div class="onoffswitch" >
                                                <input type="checkbox" class="onoffswitch-checkbox" data-url="{{ route('admin_locations.update',['id' => $location->id]) }}"  @if($location->active == 1) checked @endif id="{{$location->id}}" @if(Auth::user()->hasRole('admin_locations','edit')) disabled @endif>
                                                <label class="onoffswitch-label" for="{{$location->id}}">
                                                    <span class="onoffswitch-inner"></span>
                                                    <span class="onoffswitch-switch"></span>
                                                </label>
                                            </div>
                                        </td>
                                        <td>
                                            {{$location->brand->description}}
                                        </td>
                                        <td>
                                            @if(Auth::user()->hasRole('admin_locations','show'))
                                            <a class="open-modal" data-url="{{ url('admin_locations/'.$location->id) }}" data-toggle="modal" data-target="#showModal" title="{{__('admin_locations.index-tooltip-col1')}}" >
                                                {{$location->description}}
                                            </a>
                                            @else
                                                {{$location->description}}
                                            @endif
                                        </td>
                                        <td>{{$location->city}}</td>
                                        <td>{{$location->address}}</td>
                                        <td>{{$location->contact}}</td>
                                        <td>{{$location->phone}}</td>
                                        <td class="text-center">
                                            @if(Auth::user()->hasRole('admin_locations','edit'))
                                            <a href="{{ url('admin_locations/'.$location->id.'/edit') }}" >
                                                <i class="fa fa-pencil"  data-toggle="tooltip" title="{{__('admin_locations.index-tooltip-update')}}"></i>
                                            </a>
                                            @endif
                                            &nbsp;&nbsp;
                                            @if(Auth::user()->hasRole('admin_locations','destroy'))
                                            <a  class="confirm-toast"  data-message="{{__('admin_locations.index-confirm-message')}}"  data-location="{{ url('admin_locations/destroy/'.$location->id) }}">
                                                <i class="fa fa-trash-o text-danger"  data-toggle="tooltip" title="{{__('admin_locations.index-tooltip-delete')}}"></i>
                                            </a>
                                            @endif

                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                    <tr role="row">
                                    <tr role="row">
                                        <th class="col-md-1">{{__('admin_locations.index-header-col-0')}}</th>
                                        <th class="col-md-2">{{__('admin_locations.index-header-col-7')}}</th>
                                        <th class="col-md-2">{{__('admin_locations.index-header-col-1')}}</th>
                                        <th class="col-md-1">{{__('admin_locations.index-header-col-2')}}</th>
                                        <th class="col-md-2">{{__('admin_locations.index-header-col-3')}}</th>
                                        <th class="col-md-2">{{__('admin_locations.index-header-col-4')}}</th>
                                        <th class="col-md-1">{{__('admin_locations.index-header-col-5')}}</th>
                                        <th class="col-md-1">{{__('admin_locations.index-header-col-6')}}</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <!--<div class="col-sm-5">
                            <div class="dataTables_info" id="DataTables_Table_2_info" role="status" aria-live="polite">Showing 1 to 10 of 57 entries</div>
                        </div>-->
                        <div class="col-sm-7">
                            <div class="dataTables_paginate paging_simple_numbers" id="DataTables_Table_2_paginate">
                                {{ $locations->links() }}
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
@include('admin.locations.modal')

@endsection