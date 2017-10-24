@extends('admin.back')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>{{__('admin_profiles.create-title')}}</h5>
                <div ibox-tools="" class="ng-scope">
                    <div dropdown="" class="ibox-tools dropdown">
                        <a href="{{ url('admin_profiles') }}"><button class="btn btn-primary dim"> <i class="fa fa-arrow-left"></i></button></a>
                    </div>
                </div>
            </div>

            <form method="POST" action="{{ route('admin_profiles.store') }}" id="toast-form">
                {!! csrf_field() !!}
                <div class="ibox-content">
                    <div class="form-group">
                        <div class="col-md-2 col-md-offset-1">
                            <label for="description" >{{__('admin_profiles.db-name')}}</label>
                        </div>
                        <div class="col-md-8">
                            <input class="form-control" size="50" type="text" name="name" value="{{old("name")}}" />
                        </div>
                    </div>
                    <hr>
                    <div class="tabs-container">
                        <div class="tabs-left">
                            <ul class="nav nav-tabs" >
                                @foreach($modules as $module)
                                    <li class="@if($module->id == 1) active @endif" id="tab-index">
                                        <a data-toggle="tab" href="#mod-{{$module->id}}">{{__($module->short_name.".".$module->short_name)}}</a>
                                    </li>
                                @endforeach
                            </ul>
                            <div class="tab-content">
                                @foreach($modules as $module)
                                    <div id="mod-{{$module->id}}" class="tab-pane @if($module->id == 1) active @endif">
                                        <div class="panel-body">
                                            <p class="text-center"><span>{{__('admin_profiles.create-title-panel')}}</span></p><br>
                                            @php
                                                $functions = explode(',',$module->functions);
                                            @endphp
                                            <input type="hidden" class="form-control"  name="permission[{{$module->id}}]" />
                                            @foreach($functions as $function)
                                                <div class="input-group m-b">
                                                    <span class="input-group-addon">
                                                        <input name="permission[{{$module->id}}][{{$function}}]" class="tab-function" type="checkbox" @if(str_contains(old("permission[{{$module->id}}][{{$function}}]"),$function)) checked @endif>
                                                    </span>
                                                    <!--<input type="text" class="form-control" value="{{__('admin_profiles.crud-'.$function)}}" disabled />-->
                                                    <label class="form-control"><i>{{__('admin_profiles.crud-'.$function)}}</i></label>
                                                </div>
                                            @endforeach
                                            <br>
                                            <div class="input-group m-b">
                                                <span class="input-group-addon">
                                                    <input class="tab-function check_all" type="checkbox" data-module="{{$module->id}}">
                                                </span>
                                                <!--<input type="text" class="form-control text-success" value="{{__('admin_profiles.crud-ALL')}}" disabled />-->
                                                <label class="form-control"><i>{{__('admin_profiles.crud-ALL')}}</i></label>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                <br>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="ibox-footer text-center">
                    <button type="button" class="btn btn-w-m btn-success submit-toast" data-form-id="toast-form" data-message="{{__('admin_profiles.btn-submit')}}">{{__('admin_profiles.btn-create')}}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@push('scripts')
<script>
$(function () {
    $('.check_all').click(function(e){
        var module = this.getAttribute('data-module');
        $('#mod-'+module+' input:checkbox').prop('checked', this.checked);
    })
})
</script>
@endpush
@endsection