@extends('login')

@section('content')
    <div class="container">
        <div class="row ">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">{{__('admin_users.change_password')}}</div>
                    <div class="panel-body">
                        <form class="form-horizontal" role="form" method="POST" action="{{ route('home.store_resetpassword') }}" id="resetpwd_form">
                            {{ csrf_field() }}
                            <input type="hidden" name="user_id" value="{{$user->id}}" />

                            <div class="form-group{{ $errors->has('new_password') ? ' has-error' : '' }}">
                                <label for="new_password" class="col-md-4 control-label" >{{__('admin_users.new_password')}}</label>
                                <div class="col-md-6">
                                    <input id="new_password" type="password" class="form-control" name="new_password" value="{{ old('new_password') }}"required autofocus>

                                    @if ($errors->has('new_password'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('new_password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('new_password_confirmation') ? ' has-error' : '' }}">
                                <label for="new_password_confirmation" class="col-md-4 control-label">{{__('admin_users.new_password_confirmation')}}</label>

                                <div class="col-md-6">
                                    <input id="new_password_confirmation" type="password" class="form-control" name="new_password_confirmation" required>

                                    @if ($errors->has('new_password_confirmation'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('new_password_confirmation') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <br><br>

                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <p><button class="submit-toast btn btn-block btn-outline btn-primary" data-form-id="resetpwd_form">{{__('admin_brands.submit')}}</button></p>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(function(){

            @if($errors->any() && count($errors) > 0)

                toastr['error']("{{__('app.notify_alert_field')}}", "{{__('app.notify_alert')}}");
                @foreach($errors->keys() as $k => $info)
                    $('label[for="{{$info}}"]').css('color','red');
                @endforeach
            @endif

        });
    </script>
@endpush
