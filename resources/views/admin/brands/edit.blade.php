@extends('admin.back')

@section('content')

        <form method="POST" action="{{ route('admin_brands.update',['id' => $brand->id]) }}"  id="toast-form">
            {!! csrf_field() !!}{{ method_field('PUT') }}
            <input type="hidden" name="id" value="{{$brand->id}}" />
            <div class="row">
                <div class="form-group">
                    <div class="col-md-2 col-md-offset-1">
                        <label for="description" >{{__('admin_brands.db-description')}}</label>
                    </div>
                    <div class="col-md-8">
                        <input class="form-control" size="50" type="text" name="description" value="{{$brand->description}}" />
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="form-group">
                    <div class="col-md-2 col-md-offset-1">
                        <label for="vat" >{{__('admin_brands.db-vat')}}</label>
                    </div>
                    <div class="col-md-8">
                        <input class="form-control" size="50" type="text" name="vat" value="{{$brand->vat}}" />
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="form-group">
                    <div class="col-md-2 col-md-offset-1">
                        <label for="personal_vat" >{{__('admin_brands.db-personal_vat')}}</label>
                    </div>
                    <div class="col-md-8">
                        <input class="form-control" size="50" type="text" name="personal_vat" value="{{$brand->personal_vat}}"  />
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="form-group">
                    <div class="col-md-2 col-md-offset-1">
                        <label for="sector" >{{__('admin_brands.db-sector')}}</label>
                    </div>
                    <div class="col-md-8">
                        <input class="form-control" size="50" type="text" name="sector" value="{{$brand->sector}}" />
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="form-group">
                    <div class="col-md-2 col-md-offset-1">
                        <label for="address" >{{__('admin_brands.db-address')}}</label>
                    </div>
                    <div class="col-md-8">
                        <input class="form-control" size="50" type="text" name="address" value="{{$brand->address}}" />
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="form-group">
                    <div class="col-md-2 col-md-offset-1">
                        <label for="city" >{{__('admin_brands.db-city')}}</label>
                    </div>
                    <div class="col-md-8">
                        <input class="form-control" size="50" type="text" name="city" value="{{$brand->city}}" />
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="form-group">
                    <div class="col-md-2 col-md-offset-1">
                        <label for="zip_code" >{{__('admin_brands.db-zip_code')}}</label>
                    </div>
                    <div class="col-md-8">
                        <input class="form-control" size="50" type="text" name="zip_code" value="{{$brand->zip_code}}" />
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="form-group">
                    <div class="col-md-2 col-md-offset-1">
                        <label for="region" >{{__('admin_brands.db-region')}}</label>
                    </div>
                    <div class="col-md-8">
                        <input class="form-control" size="50" type="text" name="region" value="{{$brand->region}}" />
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="form-group">
                    <div class="col-md-2 col-md-offset-1">
                        <label for="contact" >{{__('admin_brands.db-contact')}}</label>
                    </div>
                    <div class="col-md-8">
                        <input class="form-control" size="50" type="text" name="contact" value="{{$brand->contact}}" />
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="form-group">
                    <div class="col-md-2 col-md-offset-1">
                        <label for="phone" >{{__('admin_brands.db-phone')}}</label>
                    </div>
                    <div class="col-md-8">
                        <input class="form-control" size="50" type="text" name="phone" value="{{$brand->phone}}" />
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="form-group">
                    <div class="col-md-2 col-md-offset-1">
                        <label for="mobile" >{{__('admin_brands.db-mobile')}}</label>
                    </div>
                    <div class="col-md-8">
                        <input class="form-control" size="50" type="text" name="mobile" value="{{$brand->mobile}}" />
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="form-group">
                    <div class="col-md-2 col-md-offset-1">
                        <label for="fax" >{{__('admin_brands.db-fax')}}</label>
                    </div>
                    <div class="col-md-8">
                        <input class="form-control" size="50" type="text" name="fax" value="{{$brand->fax}}" />
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="form-group">
                    <div class="col-md-2 col-md-offset-1">
                        <label for="email" >{{__('admin_brands.db-email')}}</label>
                    </div>
                    <div class="col-md-8">
                        <input class="form-control" size="50" type="text" name="email" value="{{$brand->email}}" />
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="form-group">
                    <div class="col-md-2 col-md-offset-1">
                        <label for="active" >{{__('admin_brands.db-active')}}</label>
                    </div>
                    <div class="col-md-8">
                        <input class="js-switch" type="checkbox" data-switchery="true" name="active" value="1"  @if($brand->active == 1) checked @endif style="display: none;"/>
                    </div>
                </div>
            </div>
            <br><br>



            <div class="row">
                <div class="col-md-12 text-center">
                    <p><button class="submit-toast btn btn-block btn-outline btn-primary"  data-form-id="toast-form">{{__('admin_brands.submit')}}</button></p>
                </div>
            </div>
        </form>

    </div>
@endsection