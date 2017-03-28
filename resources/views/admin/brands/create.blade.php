@extends('admin.back')

@section('content')
<div>
    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin_brands.store') }}">
    {!! csrf_field() !!}
        <div class="row">
            <div class="form-group">
                <div class="col-md-2 col-md-offset-1">
                    <label for="description" >{{__('admin_brands.db-description')}}</label>
                </div>
                <div class="col-md-8">
                    <input class="form-control" size="50" type="text" name="description" value="{{old("description")}}" />
                </div>
            </div>
        </div>

        <div class="row">
            <div class="form-group">
                <div class="col-md-2 col-md-offset-1">
                    <label for="vat" >{{__('admin_brands.db-vat')}}</label>
                </div>
                <div class="col-md-8">
                    <input class="form-control" size="50" type="text" name="vat" value="{{old("vat")}}" />
                </div>
            </div>
        </div>

        <div class="row">
            <div class="form-group">
                <div class="col-md-2 col-md-offset-1">
                    <label for="personal_vat" >{{__('admin_brands.db-personal_vat')}}</label>
                </div>
                <div class="col-md-8">
                    <input class="form-control" size="50" type="text" name="personal_vat" value="{{old("personal_vat")}}"  />
                </div>
            </div>
        </div>

        <div class="row">
            <div class="form-group">
                <div class="col-md-2 col-md-offset-1">
                    <label for="sector" >{{__('admin_brands.db-sector')}}</label>
                </div>
                <div class="col-md-8">
                    <input class="form-control" size="50" type="text" name="sector" value="{{old("sector")}}" />
                </div>
            </div>
        </div>

        <div class="row">
            <div class="form-group">
                <div class="col-md-2 col-md-offset-1">
                    <label for="address" >{{__('admin_brands.db-address')}}</label>
                </div>
                <div class="col-md-8">
                    <input class="form-control" size="50" type="text" name="address" value="{{old("address")}}" />
                </div>
            </div>
        </div>

        <div class="row">
            <div class="form-group">
                <div class="col-md-2 col-md-offset-1">
                    <label for="city" >{{__('admin_brands.db-city')}}</label>
                </div>
                <div class="col-md-8">
                    <input class="form-control" size="50" type="text" name="city" value="{{old("city")}}" />
                </div>
            </div>
        </div>

        <div class="row">
            <div class="form-group">
                <div class="col-md-2 col-md-offset-1">
                    <label for="zip_code" >{{__('admin_brands.db-zip_code')}}</label>
                </div>
                <div class="col-md-8">
                    <input class="form-control" size="50" type="text" name="zip_code" value="{{old("zip_code")}}" />
                </div>
            </div>
        </div>

        <div class="row">
            <div class="form-group">
                <div class="col-md-2 col-md-offset-1">
                    <label for="region" >{{__('admin_brands.db-region')}}</label>
                </div>
                <div class="col-md-8">
                    <input class="form-control" size="50" type="text" name="region" value="{{old("region")}}" />
                </div>
            </div>
        </div>

        <div class="row">
            <div class="form-group">
                <div class="col-md-2 col-md-offset-1">
                    <label for="contact" >{{__('admin_brands.db-contact')}}</label>
                </div>
                <div class="col-md-8">
                    <input class="form-control" size="50" type="text" name="contact" value="{{old("contact")}}" />
                </div>
            </div>
        </div>

        <div class="row">
            <div class="form-group">
                <div class="col-md-2 col-md-offset-1">
                    <label for="phone" >{{__('admin_brands.db-phone')}}</label>
                </div>
                <div class="col-md-8">
                    <input class="form-control" size="50" type="text" name="phone" value="{{old("phone")}}" />
                </div>
            </div>
        </div>

        <div class="row">
            <div class="form-group">
                <div class="col-md-2 col-md-offset-1">
                    <label for="mobile" >{{__('admin_brands.db-mobile')}}</label>
                </div>
                <div class="col-md-8">
                    <input class="form-control" size="50" type="text" name="mobile" value="{{old("mobile")}}" />
                </div>
            </div>
        </div>

        <div class="row">
            <div class="form-group">
                <div class="col-md-2 col-md-offset-1">
                    <label for="fax" >{{__('admin_brands.db-fax')}}</label>
                </div>
                <div class="col-md-8">
                    <input class="form-control" size="50" type="text" name="fax" value="{{old("fax")}}" />
                </div>
            </div>
        </div>

        <div class="row">
            <div class="form-group">
                <div class="col-md-2 col-md-offset-1">
                    <label for="email" >{{__('admin_brands.db-email')}}</label>
                </div>
                <div class="col-md-8">
                    <input class="form-control" size="50" type="text" name="email" value="{{old("email")}}" />
                </div>
            </div>
        </div>

        <div class="row">
            <div class="form-group">
                <div class="col-md-2 col-md-offset-1">
                    <label for="active" >{{__('admin_brands.db-active')}}</label>
                </div>
                <div class="col-md-8">
                    <input class="form-control" type="checkbox" name="active" value="1" checked="@if(old("active")) cheked @endif" />
                </div>
            </div>
        </div>
        <br><br>



        <div class="row">
            <div class="col-md-12 text-center">
                <p><button class="btn btn-block btn-outline btn-primary" type="submit">{{__('admin_brands.submit')}}</button></p>
            </div>
        </div>
    </form>

</div>

@endsection