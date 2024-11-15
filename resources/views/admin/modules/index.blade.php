@extends('admin.back')

@section('content')
    @push('scripts')
    <!-- Nestable List -->
    <script src="{{ asset('js/plugins/nestable/jquery.nestable.js') }}"></script>
    @endpush
<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>{{__('admin_modules.index-title')}}</h5>
                <div ibox-tools="" class="ng-scope">
                    <div dropdown="" class="ibox-tools dropdown">
                        <a href="{{ url('admin_modules/create') }}"><button class="btn btn-primary dim"> <i class="fa fa-plus"   data-toggle="tooltip" title="{{__('admin_modulesindex-tooltip-create')}}"></i> {{__('admin_brands.index-new')}}</button></a>
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
                        <div class="col-sm-12 " >
                            <table class="table table-striped table-bordered table-hover dataTables-example ng-isolate-scope dataTable" datatable="" style="display: table;" id="DataTables_Table_2" role="grid" aria-describedby="DataTables_Table_2_info">
                                <thead>
                                    <tr role="row">
                                        <th class="col-md-1">{{__('admin_modules.index-header-col-0-bis')}}</th>
                                        <th class="col-md-1">{{__('admin_modules.index-header-col-0')}}</th>
                                        <th class="col-md-2">{{__('admin_modules.index-header-col-1')}}</th>
                                        <th class="col-md-2">{{__('admin_modules.index-header-col-2')}}</th>
                                        <th class="col-md-2">{{__('admin_modules.index-header-col-3')}}</th>
                                        <th class="col-md-1">{{__('admin_modules.index-header-col-5')}}</th>
                                        <th class="col-md-1">{{__('admin_modules.index-header-col-6')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="gradeA odd" role="row" >
                                        <td colspan="7">
                                            <div class="dd" id="nestable">
                                                <ol class="dd-list" >
                                                    @foreach($modules as $module)
                                                    <li class="dd-item col-md-12" data-id="{{$module->id}}">
                                                        <div class="dd-handle col-md-1"><i class="fa fa-bars"></i></div>
                                                        <div class=" col-md-1">
                                                            <div class="onoffswitch" >
                                                                <input type="checkbox" class="onoffswitch-checkbox" data-url="{{ route('admin_modules.update',['id' => $module->id]) }}"  @if($module->active == 1) checked @endif id="{{$module->id}}" @if(!Auth::user()->hasRole('admin_modules','edit')) disabled @endif>
                                                                <label class="onoffswitch-label" for="{{$module->id}}">
                                                                    <span class="onoffswitch-inner"></span>
                                                                    <span class="onoffswitch-switch"></span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <a class="open-modal" data-url="{{ url('admin_modules/'.$module->id) }}" data-toggle="modal" data-target="#showModal" title="{{__('admin_modules.index-tooltip-col1')}}" >
                                                                {{__($module->short_name.".".$module->short_name)}}
                                                            </a>
                                                        </div>
                                                        <div class="col-md-2">{{$module->short_name}}</div>
                                                        <div class=" col-md-3">{{ str_limit($module->functions,30)}}</div>
                                                        <div class=" col-md-1 text-center"><i class="fa fa-dot-circle-o @if($module->isadmin == 1) text-success @else text-danger @endif"></i> </div>
                                                        <div class=" col-md-1 text-center">
                                                            <a href="{{ url('admin_modules/'.$module->id.'/edit') }}" >
                                                                <i class="fa fa-pencil"  data-toggle="tooltip" title="{{__('admin_modules.index-tooltip-update')}}"></i>
                                                            </a>
                                                            &nbsp;&nbsp;
                                                            <a  class="confirm-toast"  data-message="{{__('admin_modules.index-confirm-message')}}"  data-location="{{ url('admin_modules/destroy/'.$module->id) }}">
                                                                <i class="fa fa-trash-o text-danger"  data-toggle="tooltip" title="{{__('admin_modules.index-tooltip-delete')}}"></i>
                                                            </a>
                                                        </div>
                                                    </li>
                                                    @endforeach
                                                </ol>
                                            </div>
                                        </td>
                                    </tr>

                                </tbody>
                                <tfoot>
                                <tr role="row">
                                    <th class="col-md-1">{{__('admin_modules.index-header-col-0-bis')}}</th>
                                    <th class="col-md-1">{{__('admin_modules.index-header-col-0')}}</th>
                                    <th class="col-md-2">{{__('admin_modules.index-header-col-1')}}</th>
                                    <th class="col-md-2">{{__('admin_modules.index-header-col-2')}}</th>
                                    <th class="col-md-2">{{__('admin_modules.index-header-col-3')}}</th>
                                    <th class="col-md-1">{{__('admin_modules.index-header-col-5')}}</th>
                                    <th class="col-md-1">{{__('admin_modules.index-header-col-6')}}</th>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-7">
                            <div class="dataTables_paginate paging_simple_numbers" id="DataTables_Table_2_paginate">
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

            updateData({
                    _token: "{{csrf_token()}}",
                    active: $(this).is(':checked')?1:0
                },url);
        });

        function updateData(tx,url) {
            $.ajax({
                type: "PUT",
                url: url,
                data: tx,
                success: function(data) {
                    console.log(data);
                    if (data['success'])
                        toastr['success']('', data['success']);
                    else {
                        toastr['warning']('', data['warning']);
                        setTimeout(function () {
                            location.reload();
                        }, 3000);
                    }
                },
                error: function(error) {
                    location.reload();
                }
            });
        }

         var updateOutput = function (e) {
             var list = e.length ? e : $(e.target);
             var url = "{{ route('admin_modules.update',['id' => '0']) }}";
             updateData({
                    _token: "{{csrf_token()}}",
                    order: window.JSON.stringify(list.nestable('serialize'))
                },url);
             };

            $('#nestable').nestable().on('change', updateOutput);

    })
    
</script>
@endpush
@include('admin.modules.modal')

@endsection