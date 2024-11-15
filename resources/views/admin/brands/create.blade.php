@extends('admin.back')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>{{__('admin_brands.create-title')}}</h5>
                <div ibox-tools="" class="ng-scope">
                    <div dropdown="" class="ibox-tools dropdown">
                        <a href="{{ url('admin_brands') }}"><button class="btn btn-primary dim"> <i class="fa fa-arrow-left"></i></button></a>
                    </div>
                </div>
            </div>
            <hr>

            <form method="POST" action="{{ route('admin_brands.store') }}" id="toast-form">
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
                <hr>
                <div class="row">
                    <div class="form-group">
                        <div class="col-md-2 col-md-offset-1">
                            <label for="smtp_host" >{{__('admin_brands.db-smtp_host')}}</label>
                        </div>
                        <div class="col-md-8">
                            <input class="form-control" size="50" type="text" name="smtp_host" value="{{old("smtp_host")}}" />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group">
                        <div class="col-md-2 col-md-offset-1">
                            <label for="smtp_port" >{{__('admin_brands.db-smtp_port')}}</label>
                        </div>
                        <div class="col-md-8">
                            <input class="form-control" size="50" type="text" name="smtp_port" value="{{old("smtp_port")}}" />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group">
                        <div class="col-md-2 col-md-offset-1">
                            <label for="smtp_username" >{{__('admin_brands.db-smtp_username')}}</label>
                        </div>
                        <div class="col-md-8">
                            <input class="form-control" size="50" type="text" name="smtp_username" value="{{old("smtp_username")}}" />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group">
                        <div class="col-md-2 col-md-offset-1">
                            <label for="smtp_password" >{{__('admin_brands.db-smtp_password')}}</label>
                        </div>
                        <div class="col-md-8">
                            <input class="form-control" size="50" type="password" name="smtp_password" value="{{old("smtp_password")}}" />
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="form-group">
                        <div class="col-md-2 col-md-offset-1">
                            <label for="active" >{{__('admin_brands.db-active')}}</label>
                        </div>
                        <div class="col-md-8">
                            <input class="js-switch form-control" type="checkbox" data-switchery="true" name="active" value="1" @if(old("active") == 1) checked @endif style="display: none;" />
                        </div>
                    </div>
                </div>
                <br><br>



                <div class="row">
                    <div class="col-md-12 text-center">
                        <p><button class="submit-toast btn btn-block btn-outline btn-primary" data-form-id="toast-form">{{__('admin_brands.submit')}}</button></p>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection