@extends('admin.back')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>{{__('admin_users.index-title')}}</h5>
                <div ibox-tools="" class="ng-scope">
                    <div dropdown="" class="ibox-tools dropdown">
                        @if(Auth::user()->hasRole('admin_users','create'))
                        <a href="{{ url('admin_users/create') }}"><button class="btn btn-primary dim"> <i class="fa fa-plus"   data-toggle="tooltip" title="{{__('admin_usersindex-tooltip-create')}}"></i> {{__('admin_brands.index-new')}}</button></a>
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
                                        <th class="col-md-1">{{__('admin_users.index-header-col-0')}}</th>
                                        <th class="col-md-2">{{__('admin_users.index-header-col-1')}}</th>
                                        <th class="col-md-2">{{__('admin_users.index-header-col-2')}}</th>
                                        <th class="col-md-2">{{__('admin_users.index-header-col-3')}}</th>
                                        <th class="col-md-3">{{__('admin_users.index-header-col-4')}}</th>
                                        <th class="col-md-2">{{__('admin_users.index-header-col-5')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($users as $user)
                                    <tr class="gradeA odd" role="row">
                                        <td>
                                            <div class="onoffswitch" >
                                                <input type="checkbox" class="onoffswitch-checkbox" data-url="{{ route('admin_users.update',['id' => $user->id]) }}"  @if($user->active == 1) checked @endif id="{{$user->id}}" @if(!Auth::user()->hasRole('admin_users','edit')) disabled @endif>
                                                <label class="onoffswitch-label" for="{{$user->id}}">
                                                    <span class="onoffswitch-inner"></span>
                                                    <span class="onoffswitch-switch"></span>
                                                </label>
                                            </div>
                                        </td>
                                        <td>{{$user->username}}</td>
                                        <td>{{$user->name}}</td>
                                        <td>{{$user->surname}}</td>
                                        <td>{{$user->email}}</td>
                                        <td class="text-center">
                                            @if(Auth::user()->hasRole('admin_users','edit'))
                                            <a href="{{ url('admin_users/'.$user->id.'/edit') }}" >
                                                <i class="fa fa-pencil"  data-toggle="tooltip" title="{{__('admin_users.index-tooltip-update')}}"></i>
                                            </a>&nbsp;
                                            @endif
                                            @if(Auth::user()->hasRole('admin_users','resetPwd'))
                                            <a class="open-modal" data-url="{{ url('admin_users/resetPwd/'.$user->id) }}" data-toggle="modal" data-target="#showModal" title="{{__('admin_users.index-tooltip-password')}}" id="{{$user->id}}">
                                                <i class="fa fa-unlock-alt"  data-toggle="tooltip" title="{{__('admin_users.index-tooltip-password')}}"></i>
                                            </a>&nbsp;
                                            @endif
                                            @if(Auth::user()->hasRole('admin_users','destroy'))
                                            <a  class="confirm-toast"  data-message="{{__('admin_users.index-confirm-message')}}"  data-location="{{ url('admin_users/destroy/'.$user->id) }}">
                                                <i class="fa fa-trash-o text-danger"  data-toggle="tooltip" title="{{__('admin_users.index-tooltip-delete')}}"></i>
                                            </a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                    <tr role="row">
                                        <th class="col-md-1">{{__('admin_users.index-header-col-0')}}</th>
                                        <th>{{__('admin_users.index-header-col-1')}}</th>
                                        <th>{{__('admin_users.index-header-col-2')}}</th>
                                        <th>{{__('admin_users.index-header-col-3')}}</th>
                                        <th>{{__('admin_users.index-header-col-4')}}</th>
                                        <th>{{__('admin_users.index-header-col-5')}}</th>
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
                                {{ $users->links() }}
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
                    if(data['success'])
                        toastr['success']('', data['success']);
                    else {
                        toastr['warning']('', data['warning']);
                        setTimeout(function(){
                            location.reload();
                        },2000);
                    }
                },
                error: function(error) {
                    location.reload();
                }
            });
        });
        
    })
    
</script>
@endpush
@include('admin.users.modal')

@endsection