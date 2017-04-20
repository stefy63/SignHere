@extends('admin.back')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>{{__('admin_locations.edit-title')}}</h5>
                <div ibox-tools="" class="ng-scope">
                    <div dropdown="" class="ibox-tools dropdown">
                        <a href="{{ url('admin_locations') }}"><span class="badge badge-info"> <i class="fa fa-arrow-left"></i></span></a>
                    </div>
                </div>
            </div>
            <hr>


            <form method="POST" action="{{ route('admin_locations.update',['id' => $location->id]) }}"  id="toast-form">
            {!! csrf_field() !!}{{ method_field('PUT') }}
                <input type="hidden" name="id" value="{{$location->id}}" />
                <!-- AZIENDA -->
                <div class="row">
                    <div class="form-group">
                        <div class="col-md-2 col-md-offset-1">
                            <label for="brand_id" >{{__('admin_locations.db-brand_id')}}</label>
                        </div>
                        <div class="col-md-8">
                            <select class="form-control" name="brand_id">
                                @foreach($brands as $brand)
                                 <option value="{{ $brand->id }}" @if($location->brand_id == $brand->id) selected @endif>{{ $brand->description}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <!-- FINE AZIENDA -->
                <div class="row">
                    <div class="form-group">
                        <div class="col-md-2 col-md-offset-1">
                            <label for="description" >{{__('admin_locations.db-description')}}</label>
                        </div>
                        <div class="col-md-8">
                            <input class="form-control" size="50" type="text" name="description" value="{{$location->description}}" />
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group">
                        <div class="col-md-2 col-md-offset-1">
                            <label for="sector" >{{__('admin_locations.db-sector')}}</label>
                        </div>
                        <div class="col-md-8">
                            <input class="form-control" size="50" type="text" name="sector" value="{{$location->sector}}" />
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group">
                        <div class="col-md-2 col-md-offset-1">
                            <label for="address" >{{__('admin_locations.db-address')}}</label>
                        </div>
                        <div class="col-md-8">
                            <input class="form-control" size="50" type="text" name="address" value="{{$location->address}}" />
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group">
                        <div class="col-md-2 col-md-offset-1">
                            <label for="city" >{{__('admin_locations.db-city')}}</label>
                        </div>
                        <div class="col-md-8">
                            <input class="form-control" size="50" type="text" name="city" value="{{$location->city}}" />
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group">
                        <div class="col-md-2 col-md-offset-1">
                            <label for="zip_code" >{{__('admin_locations.db-zip_code')}}</label>
                        </div>
                        <div class="col-md-8">
                            <input class="form-control" size="50" type="text" name="zip_code" value="{{$location->zip_code}}" />
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group">
                        <div class="col-md-2 col-md-offset-1">
                            <label for="region" >{{__('admin_locations.db-region')}}</label>
                        </div>
                        <div class="col-md-8">
                            <input class="form-control" size="50" type="text" name="region" value="{{$location->region}}" />
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group">
                        <div class="col-md-2 col-md-offset-1">
                            <label for="contact" >{{__('admin_locations.db-contact')}}</label>
                        </div>
                        <div class="col-md-8">
                            <input class="form-control" size="50" type="text" name="contact" value="{{$location->contact}}" />
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group">
                        <div class="col-md-2 col-md-offset-1">
                            <label for="phone" >{{__('admin_locations.db-phone')}}</label>
                        </div>
                        <div class="col-md-8">
                            <input class="form-control" size="50" type="text" name="phone" value="{{$location->phone}}" />
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group">
                        <div class="col-md-2 col-md-offset-1">
                            <label for="mobile" >{{__('admin_locations.db-mobile')}}</label>
                        </div>
                        <div class="col-md-8">
                            <input class="form-control" size="50" type="text" name="mobile" value="{{$location->mobile}}" />
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group">
                        <div class="col-md-2 col-md-offset-1">
                            <label for="fax" >{{__('admin_locations.db-fax')}}</label>
                        </div>
                        <div class="col-md-8">
                            <input class="form-control" size="50" type="text" name="fax" value="{{$location->fax}}" />
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group">
                        <div class="col-md-2 col-md-offset-1">
                            <label for="email" >{{__('admin_locations.db-email')}}</label>
                        </div>
                        <div class="col-md-8">
                            <input class="form-control" size="50" type="text" name="email" value="{{$location->email}}" />
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group">
                        <div class="col-md-2 col-md-offset-1">
                            <label for="active" >{{__('admin_locations.db-active')}}</label>
                        </div>
                        <div class="col-md-8">
                            <input class="js-switch" type="checkbox" data-switchery="true" name="active" value="1"  @if($location->active == 1) checked @endif style="display: none;"/>
                        </div>
                    </div>
                </div>
                <br><br>



                <div class="row">
                    <div class="col-md-12 text-center">
                        <p><button class="submit-toast btn btn-block btn-outline btn-primary"  data-form-id="toast-form">{{__('admin_locations.submit')}}</button></p>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection