@extends('admin.back')

@section('content')

        <form method="POST" action="{{ route('admin_users.update',['id' => $user->id]) }}"  id="toast-form">
            {!! csrf_field() !!}{{ method_field('PUT') }}
            <input type="hidden" name="id" value="{{$user->id}}" />
            <input type="hidden" name="user_id" value="{{Auth::user()->id}}" />
            <div class="row">
                <div class="form-group">
                    <div class="col-md-2 col-md-offset-1">
                        <label for="username" >{{__('admin_users.db-username')}}</label>
                    </div>
                    <div class="col-md-8">
                        <input class="form-control" size="50" type="text" name="username" value="{{$user->username}}" />
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="form-group">
                    <div class="col-md-2 col-md-offset-1">
                        <label for="name" >{{__('admin_users.db-name')}}</label>
                    </div>
                    <div class="col-md-8">
                        <input class="form-control" size="50" type="text" name="name" value="{{$user->name}}" />
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="form-group">
                    <div class="col-md-2 col-md-offset-1">
                        <label for="surname" >{{__('admin_users.db-surname')}}</label>
                    </div>
                    <div class="col-md-8">
                        <input class="form-control" size="50" type="text" name="surname" value="{{$user->surname}}"  />
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="form-group">
                    <div class="col-md-2 col-md-offset-1">
                        <label for="password" >{{__('admin_users.db-password')}}</label>
                    </div>
                    <div class="col-md-8">
                        <input class="form-control" size="50" type="password" name="password" value="{{$user->password}}" />
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="form-group">
                    <div class="col-md-2 col-md-offset-1">
                        <label for="email" >{{__('admin_users.db-email')}}</label>
                    </div>
                    <div class="col-md-8">
                        <input class="form-control" size="50" type="text" name="email" value="{{$user->email}}" />
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="form-group">
                    <div class="col-md-2 col-md-offset-1">
                        <label for="active" >{{__('admin_users.db-active')}}</label>
                    </div>
                    <div class="col-md-8">
                        <input class="js-switch" type="checkbox" data-switchery="true" name="active" value="1"  @if($user->active == 1) checked @endif style="display: none;"/>
                    </div>
                </div>
            </div>
            <br><br>



            <div class="row">
                <div class="col-md-12 text-center">
                    <p><button class="submit-toast btn btn-block btn-outline btn-primary"  data-form-id="toast-form">{{__('admin_users.submit')}}</button></p>
                </div>
            </div>
        </form>

    </div>
@endsection