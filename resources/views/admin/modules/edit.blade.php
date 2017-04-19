@extends('admin.back')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>{{__('admin_modules.edit-title')}}</h5>
                <div ibox-tools="" class="ng-scope">
                    <div dropdown="" class="ibox-tools dropdown">
                        <a href="{{ url('admin_modules') }}"><span class="badge badge-info"> <i class="fa fa-arrow-left"></i></span></a>
                    </div>
                </div>
            </div>

            <div class="ibox-content">
                <form method="POST" action="{{ route('admin_modules.update',['id' => $module->id]) }}"  id="toast-form">
                    {!! csrf_field() !!}{{ method_field('PUT') }}
                    <input type="hidden" name="user_id" value="{{Auth::user()->id}}" />


                    <div class="row">
                        <div class="form-group">
                            <div class="col-md-2 col-md-offset-1">
                                <label for="name" >{{__('admin_modules.db-name')}}</label>
                            </div>
                            <div class="col-md-8">
                                <input class="form-control" size="50" type="text" name="name" value="{{$module->name}}" />
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group">
                            <div class="col-md-2 col-md-offset-1">
                                <label for="short_name" >{{__('admin_modules.db-short_name')}}</label>
                            </div>
                            <div class="col-md-8">
                                <input class="form-control" size="50" type="text" name="short_name" value="{{$module->short_name}}" />
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group">
                            <div class="col-md-2 col-md-offset-1">
                                <label for="functions" >{{__('admin_modules.db-functions')}}</label>
                            </div>
                            <div class="col-md-8">
                                <input class="form-control" size="50" type="text" name="functions" value="{{$module->functions}}" />
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group">
                            <div class="col-md-2 col-md-offset-1">
                                <label for="icon" >{{__('admin_modules.db-icon')}}</label>
                            </div>
                            <div class="col-md-8">
                                <input class="form-control" size="50" type="text" name="icon" value="{{$module->icon}}" />
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group">
                            <div class="col-md-2 col-md-offset-1">
                                <label for="isadmin" >{{__('admin_modules.db-isadmin')}}</label>
                            </div>
                            <div class="col-md-8">
                                <div class="onoffswitch" >
                                    <input type="checkbox" name="isadmin" class="onoffswitch-checkbox" @if($module->isadmin == 1) checked @endif id="check1">
                                    <label class="onoffswitch-label" for="check1">
                                        <span class="onoffswitch-inner"></span>
                                        <span class="onoffswitch-switch"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group">
                            <div class="col-md-2 col-md-offset-1">
                                <label for="active" >{{__('admin_modules.db-active')}}</label>
                            </div>
                            <div class="col-md-8">
                                <input class="js-switch form-control" type="checkbox" data-switchery="true" name="active" value="1" @if($module->active == 1) checked @endif style="display: none;" />
                            </div>
                        </div>
                    </div>
                    <br><br>



                    <div class="row">
                        <div class="col-md-12 text-center">
                            <p><button class="submit-toast btn btn-block btn-outline btn-primary"  data-form-id="toast-form">{{__('admin_modules.submit')}}</button></p>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection