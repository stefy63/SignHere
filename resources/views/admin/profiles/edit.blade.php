@extends('admin.back')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>{{__('admin_profiles.edit-title')}}</h5>
                <div ibox-tools="" class="ng-scope">
                    <div dropdown="" class="ibox-tools dropdown">
                        <a href="{{ url('admin_profiles/create') }}"> <i class="fa fa-plus-square-o"   data-toggle="tooltip" title="{{__('admin_profiles.index-tooltip-create')}}"></i></a>
                    </div>
                </div>
            </div>
            <form method="POST" action="{{ route('admin_profiles.update',['id' => $profile->id]) }}"  id="toast-form">
            {!! csrf_field() !!}{{ method_field('PUT') }}

            <div class="ibox-content">
                <div class="form-group">
                    <div class="col-md-2 col-md-offset-1">
                        <label for="description" >{{__('admin_profiles.db-name')}}</label>
                    </div>
                    <div class="col-md-8">
                        <input class="form-control" size="50" type="text" name="name" value="{{$profile->name}}" />
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
                                        <p class="text-center"><span>Elenco funzioni</span></p><br>
                                        @php
                                            $functions = explode(',',$module->functions);
                                            $permission = ($my_mod = $profile->getModules($module->short_name)->first())?@$my_mod->pivot->permission:"";
                                        @endphp
                                        <input type="hidden" class="form-control"  name="permission[{{$module->id}}]" />
                                        @foreach($functions as $function)
                                            <div class="input-group m-b">
                                                <span class="input-group-addon">
                                                    <input name="permission[{{$module->id}}][{{$function}}]" class="tab-function" type="checkbox" @if(str_contains($permission,$function) || $permission == "ALL") checked @endif>
                                                </span>
                                                <input type="text" class="form-control" value="{{__('admin_profiles.crud-'.$function)}}" disabled />
                                            </div>
                                        @endforeach
                                        <!--<div class="input-group m-b">
                                            <span class="input-group-addon">
                                                <input name="{{$module->short_name}}[ALL]" class="tab-function" type="checkbox" @if($permission == "ALL") checked @endif>
                                            </span>
                                            <input type="text" class="form-control" value="{{__('admin_profiles.crud-ALL')}}" disabled />
                                        </div>-->
                                        <br>
                                        <div class="input-group m-b">
                                            <span class="input-group-addon">
                                                <input class="tab-function check_all" type="checkbox" data-module="{{$module->id}}">
                                            </span>
                                            <input type="text" class="form-control text-success" value="{{__('admin_profiles.crud-ALL')}}" disabled />
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            <br>
                            <div class="text-center">
                                <button type="button" id="profile-submit" class="btn btn-w-m btn-success submit-toast" data-form-id="toast-form" data-message="{{__('admin_profiles.btn-submit')}}">{{__('admin_profiles.btn-submit')}}</button>
                           </div>
                        </div>
                    </div>
                </div>
            </div>
            </form>

        </div>
    </div>
</div>

<script>
$(function () {
    $('.check_all').click(function(e){
        var module = this.getAttribute('data-module');
        $('#mod-'+module+' input:checkbox').prop('checked', this.checked);
    })
})
</script>

@endsection