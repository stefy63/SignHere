@extends('admin.back')

@section('content')
<div>

    <form method="POST" action="{{ route('admin_users.store') }}" id="toast-form">
    {!! csrf_field() !!}
        <input type="hidden" name="user_id" value="{{Auth::user()->id}}" />
        <div class="row">
            <div class="form-group">
                <div class="col-md-2 col-md-offset-1">
                    <label for="username" >{{__('admin_users.db-username')}}</label>
                </div>
                <div class="col-md-8">
                    <input class="form-control" size="50" type="text" name="username" value="{{old("username")}}" />
                </div>
            </div>
        </div>

        <div class="row">
            <div class="form-group">
                <div class="col-md-2 col-md-offset-1">
                    <label for="name" >{{__('admin_users.db-name')}}</label>
                </div>
                <div class="col-md-8">
                    <input class="form-control" size="50" type="text" name="name" value="{{old("name")}}" />
                </div>
            </div>
        </div>

        <div class="row">
            <div class="form-group">
                <div class="col-md-2 col-md-offset-1">
                    <label for="surname" >{{__('admin_users.db-surname')}}</label>
                </div>
                <div class="col-md-8">
                    <input class="form-control" size="50" type="text" name="surname" value="{{old("surname")}}"  />
                </div>
            </div>
        </div>

        <div class="row">
            <div class="form-group">
                <div class="col-md-2 col-md-offset-1">
                    <label for="password" >{{__('admin_users.db-password')}}</label>
                </div>
                <div class="col-md-8">
                    <input class="form-control" size="50" type="password" name="password" value="{{old("password")}}" />
                </div>
            </div>
        </div>
<!--
        <div class="row">
            <div class="form-group">
                <div class="col-md-2 col-md-offset-1">
                    <label for="password" >{{__('admin_users.db-password')}}</label>
                </div>
                <div class="col-md-8">
                    <input class="form-control" size="50" type="text" name="password" value="{{old("password")}}" />
                </div>
            </div>
        </div>
-->
        <div class="row">
            <div class="form-group">
                <div class="col-md-2 col-md-offset-1">
                    <label for="email" >{{__('admin_users.db-email')}}</label>
                </div>
                <div class="col-md-8">
                    <input class="form-control" size="50" type="text" name="email" value="{{old("email")}}" />
                </div>
            </div>
        </div>

        <div class="row">
            <div class="form-group">
                <div class="col-md-2 col-md-offset-1">
                    <label for="active" >{{__('admin_users.db-active')}}</label>
                </div>
                <div class="col-md-8">
                    <input class="js-switch form-control" type="checkbox" data-switchery="true" name="active" value="1" @if(old("active") == 1) checked @endif style="display: none;" />
                </div>
            </div>
        </div>
        <br>

        <div class="row">
            <div class="col-md-12 text-center">
                <p><button class="submit-toast btn btn-block btn-outline btn-primary" data-form-id="toast-form">{{__('admin_brands.submit')}}</button></p>
            </div>
        </div>
    </form>

</div>
@endsection