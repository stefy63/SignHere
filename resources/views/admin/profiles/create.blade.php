@extends('admin.back')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>{{__('admin_profiles.create-title')}}</h5>
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
                                            <p class="text-center"><span>Elenco funzioni</span></p><br>
                                            @php
                                                $functions = explode(',',$module->functions);
                                            @endphp
                                            <input type="hidden" class="form-control"  name="permission[{{$module->id}}]" />
                                            @foreach($functions as $function)
                                                <div class="input-group m-b">
                                                    <span class="input-group-addon">
                                                        <input name="permission[{{$module->id}}][{{$function}}]" class="tab-function" type="checkbox" @if(str_contains(old("permission[{{$module->id}}][{{$function}}]"),$function)) checked @endif>
                                                    </span>
                                                    <input type="text" class="form-control" value="{{__('admin_profiles.crud-'.$function)}}" disabled />
                                                </div>
                                            @endforeach
                                            <br>
                                        </div>
                                    </div>
                                @endforeach
                                <br>
                                <div class="text-center">
                                    <button type="button" class="btn btn-w-m btn-success submit-toast" data-form-id="toast-form" data-message="{{__('admin_profiles.btn-submit')}}">{{__('admin_profiles.btn-create')}}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection