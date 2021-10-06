@extends('admin.back')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>{{__('admin_mail_template.index-title')}}</h5>
                <div ibox-tools="" class="ng-scope">
                    <div dropdown="" class="ibox-tools dropdown">
                        <a href="{{ url('admin_mail_template/create') }}"><button class="btn btn-primary dim"> <i class="fa fa-plus"   data-toggle="tooltip" title="{{__('admin_mail_template.index-tooltip-create')}}"></i> {{__('admin_brands.index-new')}}</button></a>
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
                            <div id="DataTables_Table_2_filter" class="dataTables_filter pull-right">
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
                                        <th class="col-md-1">{{__('admin_mail_template.index-header-col-0')}}</th>
                                        <th class="col-md-2">{{__('admin_mail_template.index-header-col-1')}}</th>
                                        <th class="col-md-2">{{__('admin_mail_template.index-header-col-2')}}</th>
                                        <th class="col-md-2">{{__('admin_mail_template.index-header-col-4')}}</th>
                                        <th class="col-md-1 text-center">{{__('admin_mail_template.index-header-col-3')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($templates as $template)
                                    <tr class="gradeA odd" role="row">
                                        <td>
                                            <div class="onoffswitch" >
                                                <input type="checkbox" class="onoffswitch-checkbox" data-url="{{ route('admin_mail_template.update',['id' => $template->id]) }}"  @if($template->active == 1) checked @endif id="{{$template->id}}">
                                                <label class="onoffswitch-label" for="{{$template->id}}">
                                                    <span class="onoffswitch-inner"></span>
                                                    <span class="onoffswitch-switch"></span>
                                                </label>
                                            </div>
                                        </td>
                                        <td>{{$template->name}}</td>
                                        <td>{{$template->description}}</td>
                                        <td>{{$template->brand()->first()->description}}</td>
                                        <td class="text-center">
                                            <a href="{{ url('admin_mail_template/'.$template->id.'/edit') }}" >
                                                <i class="fa fa-pencil"  data-toggle="tooltip" title="{{__('admin_mail_template.index-tooltip-update')}}"></i>
                                            </a>
                                            &nbsp;&nbsp;
                                            <a  class="confirm-toast"  data-message="{{__('admin_mail_template.index-confirm-message')}}"  data-location="{{ url('admin_mail_template/destroy/'.$template->id) }}">
                                                <i class="fa fa-trash-o text-danger"  data-toggle="tooltip" title="{{__('admin_mail_template.index-tooltip-delete')}}"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                    <tr role="row">
                                        <th class="col-md-1">{{__('admin_mail_template.index-header-col-0')}}</th>
                                        <th class="col-md-2">{{__('admin_mail_template.index-header-col-1')}}</th>
                                        <th class="col-md-2">{{__('admin_mail_template.index-header-col-2')}}</th>
                                        <th class="col-md-2">{{__('admin_mail_template.index-header-col-4')}}</th>
                                        <th class="col-md-1 text-center">{{__('admin_mail_template.index-header-col-3')}}</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-7">
                            <div class="dataTables_paginate paging_simple_numbers" id="DataTables_Table_2_paginate">
                                {{ $templates->links() }}
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

@endsection
@push('scripts')<script>
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