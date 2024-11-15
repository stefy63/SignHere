@extends('admin.back')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>{{__('admin_users.create-title')}}</h5>
                <div ibox-tools="" class="ng-scope">
                    <div dropdown="" class="ibox-tools dropdown">
                        <a href="{{ url('admin_users') }}"><button class="btn btn-primary dim"> <i class="fa fa-arrow-left"></i></button></a>
                    </div>
                </div>
            </div>
            <hr>

            <form method="POST" action="{{ route('admin_users.store') }}" id="toast-form">
                {!! csrf_field() !!}
                <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                <div class="tabs-container">
                    <div class="tabs-left">
                        <ul class="nav nav-tabs" >
                            <li class="active" id="tab-index">
                                <a data-toggle="tab" href="#general">{{__('admin_users.tab-general')}}</a>
                            </li>
                            <li class="" id="tab-index">
                                <a data-toggle="tab" href="#locations">{{__('admin_users.tab-locations')}}</a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div id="general" class="tab-pane active">
                                <div class="panel-body">
                                    <p class="text-center"><span>{{__('admin_users.create-title-panel')}}</span></p><br>
                                    <div class="row">
                                        <div class="form-group">
                                            <div class="col-md-2 col-lg-2 col-xs-2">
                                                <label for="username" >{{__('admin_users.db-username')}}</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input class="form-control" size="50" type="text" name="username" value="{{old("username")}}" />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group">
                                            <div class="col-md-2 col-lg-2 col-xs-2">
                                                <label for="name" >{{__('admin_users.db-name')}}</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input class="form-control" size="50" type="text" name="name" value="{{old("name")}}" />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group">
                                            <div class="col-md-2">
                                                <label for="surname" >{{__('admin_users.db-surname')}}</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input class="form-control" size="50" type="text" name="surname" value="{{old("surname")}}"  />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group">
                                            <div class="col-md-2">
                                                <label for="password" >{{__('admin_users.db-password')}}</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input class="form-control" size="50" type="password" name="password" value="{{old("password")}}" autocomplete="off" />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group">
                                            <div class="col-md-2">
                                                <label for="email" >{{__('admin_users.db-email')}}</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input class="form-control" size="50" type="text" name="email" value="{{old("email")}}" />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group">
                                            <div class="col-md-2">
                                                <label for="profile_id" >{{__('admin_users.db-profile')}}</label>
                                            </div>
                                            <div class="col-md-8">
                                                <select class="form-control" name="profile_id" >
                                                    <option value="">{{__('admin_users.db-profile_select')}}</option>
                                                    @foreach($profiles as $profile)
                                                        <option value="{{$profile->id}}" @if($profile->id == old('profile_id')) selected  @endif>
                                                            {{$profile->name}}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group">
                                            <div class="col-md-2">
                                                <label for="active" >{{__('admin_users.db-active')}}</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input class="js-switch form-control" type="checkbox" data-switchery="true" name="active" value="1" @if(old("active") == 1) checked @endif style="display: none;" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="locations" class="tab-pane">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="form-group">
                                            <div class="col-md-3 col-lg-3 col-xs-3">
                                                <label for="locations" >{{__('admin_users.db-locations')}}</label>
                                            </div>
                                            <div class="col-md-8">
                                                @if($locations)
                                                    <select class="col-md-12" name="locations[]" multiple size="12" >
                                                        @foreach($locations as $location)
                                                            <option value="{{$location->id}}" {{ (collect(old('locations'))->contains($location->id)) ? 'selected':'' }}>
                                                                {{$location->description}}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <br>

                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <p><button class="submit-toast btn btn-block btn-outline btn-primary" data-form-id="toast-form">{{__('admin_brands.submit')}}</button></p>
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