@extends('admin.back')

@section('content')

        <form method="POST" action="{{ route('admin_clients.update',['id' => $client->id]) }}"  id="toast-form">
            {!! csrf_field() !!}{{ method_field('PUT') }}
            <div class="row">
                <div class="form-group">
                    <div class="col-md-2 col-md-offset-1">
                        <label for="name" >{{__('admin_clients.db-name')}}</label>
                    </div>
                    <div class="col-md-8">
                        <input class="form-control" size="50" type="text" name="name" value="{{$client->name}}" />
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="form-group">
                    <div class="col-md-2 col-md-offset-1">
                        <label for="surname" >{{__('admin_clients.db-surname')}}</label>
                    </div>
                    <div class="col-md-8">
                        <input class="form-control" size="50" type="text" name="surname" value="{{$client->surname}}" />
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="form-group">
                    <div class="col-md-2 col-md-offset-1">
                        <label for="email" >{{__('admin_clients.db-email')}}</label>
                    </div>
                    <div class="col-md-8">
                        <input class="form-control" size="50" type="text" name="email" value="{{$client->email}}" />
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="form-group">
                    <div class="col-md-2 col-md-offset-1">
                        <label for="vat" >{{__('admin_clients.db-vat')}}</label>
                    </div>
                    <div class="col-md-8">
                        <input class="form-control" size="50" type="text" name="vat" value="{{$client->vat}}" />
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="form-group">
                    <div class="col-md-2 col-md-offset-1">
                        <label for="personal_vat" >{{__('admin_clients.db-personal_vat')}}</label>
                    </div>
                    <div class="col-md-8">
                        <input class="form-control" size="50" type="text" name="personal_vat" value="{{$client->personal_vat}}"  />
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="form-group">
                    <div class="col-md-2 col-md-offset-1">
                        <label for="address" >{{__('admin_clients.db-address')}}</label>
                    </div>
                    <div class="col-md-8">
                        <input class="form-control" size="50" type="text" name="address" value="{{$client->address}}" />
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="form-group">
                    <div class="col-md-2 col-md-offset-1">
                        <label for="city" >{{__('admin_clients.db-city')}}</label>
                    </div>
                    <div class="col-md-8">
                        <input class="form-control" size="50" type="text" name="city" value="{{$client->city}}" />
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="form-group">
                    <div class="col-md-2 col-md-offset-1">
                        <label for="region" >{{__('admin_clients.db-region')}}</label>
                    </div>
                    <div class="col-md-8">
                        <input class="form-control" size="50" type="text" name="region" value="{{$client->region}}" />
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="form-group">
                    <div class="col-md-2 col-md-offset-1">
                        <label for="zip_code" >{{__('admin_clients.db-zip_code')}}</label>
                    </div>
                    <div class="col-md-8">
                        <input class="form-control" size="50" type="text" name="zip_code" value="{{$client->zip_code}}" />
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="form-group">
                    <div class="col-md-2 col-md-offset-1">
                        <label for="contact" >{{__('admin_clients.db-contact')}}</label>
                    </div>
                    <div class="col-md-8">
                        <input class="form-control" size="50" type="text" name="contact" value="{{$client->contact}}" />
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="form-group">
                    <div class="col-md-2 col-md-offset-1">
                        <label for="phone" >{{__('admin_clients.db-phone')}}</label>
                    </div>
                    <div class="col-md-8">
                        <input class="form-control" size="50" type="text" name="phone" value="{{$client->phone}}" />
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="form-group">
                    <div class="col-md-2 col-md-offset-1">
                        <label for="mobile" >{{__('admin_clients.db-mobile')}}</label>
                    </div>
                    <div class="col-md-8">
                        <input class="form-control" size="50" type="text" name="mobile" value="{{$client->mobile}}" />
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="form-group">
                    <div class="col-md-2 col-md-offset-1">
                        <label for="active" >{{__('admin_clients.db-active')}}</label>
                    </div>
                    <div class="col-md-8">
                        <input class="js-switch" type="checkbox" data-switchery="true" name="active" value="1"  @if($client->active == 1) checked @endif style="display: none;"/>
                    </div>
                </div>
            </div>
            <br><br>


            <div class="row">
                <div class="col-md-12 text-center">
                    <p><button class="submit-toast btn btn-block btn-outline btn-primary"  data-form-id="toast-form">{{__('admin_clients.submit')}}</button></p>
                </div>
            </div>
        </form>

    </div>
@endsection