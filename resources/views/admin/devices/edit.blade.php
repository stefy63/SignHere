@extends('admin.back')

@section('content')

        <form method="POST" action="{{ route('admin_devices.update',['id' => $device->id]) }}"  id="toast-form">
            {!! csrf_field() !!}{{ method_field('PUT') }}
            <input type="hidden" name="user_id" value="{{Auth::user()->id}}" />
            <div class="row">
                <div class="form-group">
                    <div class="col-md-2 col-md-offset-1">
                        <label for="description" >{{__('admin_devices.db-description')}}</label>
                    </div>
                    <div class="col-md-8">
                        <input class="form-control" size="50" type="text" name="description" value="{{$device->description}}" />
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="form-group">
                    <div class="col-md-2 col-md-offset-1">
                        <label for="serial" >{{__('admin_devices.db-serial')}}</label>
                    </div>
                    <div class="col-md-8">
                        <input class="form-control" size="50" type="text" name="serial" value="{{$device->serial}}" />
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="form-group">
                    <div class="col-md-2 col-md-offset-1">
                        <label for="active" >{{__('admin_devices.db-active')}}</label>
                    </div>
                    <div class="col-md-8">
                        <input class="js-switch" type="checkbox" data-switchery="true" name="active" value="1"  @if($device->active == 1) checked @endif style="display: none;"/>
                    </div>
                </div>
            </div>
            <br><br>



            <div class="row">
                <div class="col-md-12 text-center">
                    <p><button class="submit-toast btn btn-block btn-outline btn-primary"  data-form-id="toast-form">{{__('admin_devices.submit')}}</button></p>
                </div>
            </div>
        </form>

    </div>
@endsection