@extends('admin.back')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>{{__('admin_acls.create-title')}}</h5>
                </div>
                <form method="POST" action="{{ route('admin_acls.store') }}" id="toast-form" style="background-color: white">
                {!! csrf_field() !!}
                <div class="">
                    <br>
                    <div class="">
                        <div class="col-md-2 col-md-offset-1">
                            <label for="name" >{{__('admin_acls.db-name')}}</label>
                        </div>
                        <div class="col-md-8">
                            <input class="form-control" size="50" type="text" name="name" value="{{old("name")}}" />
                        </div>
                    </div>
                    <div class="">
                        <div class="col-md-2 col-md-offset-1">
                            <label for="description" >{{__('admin_acls.db-description')}}</label>
                        </div>
                        <div class="col-md-8">
                            <input class="form-control" size="50" type="text" name="description" value="{{old("description")}}" />
                        </div>
                    </div>
                    <div class="">
                        <div class="col-md-2 col-md-offset-1">
                            <label for="brand" >{{__('admin_acls.db-select-brands')}}</label>
                        </div>
                        <div class="col-md-8">
                            <select class="form-control col-md-8" name="brand_id" id="select-brands" data-url="{{ url('admin_acls/store_getitem') }}">
                                @foreach($brands as $brand)
                                    <option class="form-control col-md-8" value="{{$brand->id}}">{{$brand->description}} </option>
                                @endforeach
                        </select>
                        </div>
                    </div>
                    <div class="">
                        <div class="col-md-2 col-md-offset-1">
                            <label for="parent_id" >{{__('admin_acls.db-select-acls')}}</label>
                        </div>
                        <div class="col-md-8">
                            <select class="form-control col-md-8" name="parent_id" >
                                @foreach($acls as $acl)
                                    <option class="form-control col-md-8" value="{{$acl->id}}">{{$acl->description}} </option>
                                @endforeach
                        </select>
                        </div>
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="tabs-container">
                        <div class="tabs-left">
                            <ul class="nav nav-tabs" >
                                <li class="active" id="tab-index">
                                    <a data-toggle="tab" href="#locations">{{__('admin_locations.admin_locations')}}</a>
                                </li>
                                <li class="" id="tab-index">
                                    <a data-toggle="tab" href="#devices">{{__('admin_devices.admin_devices')}}</a>
                                </li>
                                <li class="" id="tab-index">
                                    <a data-toggle="tab" href="#users">{{__('admin_users.admin_users')}}</a>
                                </li>
                                <li class="" id="tab-index">
                                    <a data-toggle="tab" href="#profiles">{{__('admin_profiles.admin_profiles')}}</a>
                                </li>
                            </ul>
                            <div class="tab-content">

                                <!-- LOCATIONS TAB -->
                                <div id="locations" class="tab-pane active">
                                    <div class="panel-body">
                                        <p class="text-center"><span>{{__('admin_acls.locations-panel-title')}}</span></p>
                                        <br>
                                        <div class="input-group m-b col-md-offset-3"></div>
                                        <br>
                                        <br>
                                    </div>
                                </div>
                                <!-- DEVICES TAB-->
                                <div id="devices" class="tab-pane">
                                    <div class="panel-body">
                                        <p class="text-center"><span>{{__('admin_acls.devices-panel-title')}}</span></p>
                                        <br>
                                        <div class="input-group m-b col-md-offset-3"></div>
                                        <br>
                                    </div>
                                </div>
                                <!-- USERS TAB -->
                                <div id="users" class="tab-pane">
                                    <div class="panel-body">
                                        <p class="text-center"><span>{{__('admin_acls.users-panel-title')}}</span></p>
                                        <br>
                                        <div class="input-group m-b col-md-offset-3"></div>
                                        <br>
                                    </div>
                                </div>
                                <!-- PROFILES TAB -->
                                <div id="profiles" class="tab-pane">
                                    <div class="panel-body">
                                        <p class="text-center"><span>{{__('admin_acls.profiles-panel-title')}}</span></p>
                                        <br>
                                        <div class="input-group m-b col-md-offset-3"></div>
                                        <br>
                                    </div>
                                </div>
                            </div>
                            <br>
                        </div>
                    </div>
                </div>
                <div class="ibox-footer text-center">
                    <button type="button" class="btn btn-w-m btn-success submit-toast" data-form-id="toast-form" data-message="{{__('admin_acls.btn-submit')}}">{{__('admin_acls.btn-create')}}</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        $(function () {

            $('#select-brands').change(function (e) {
                e.preventDefault();
                var url = this.getAttribute('data-url');
                var brand = '/' + this.options[this.selectedIndex].value;
                url = url + brand;
                console.log(url);
                $.ajax({
                    type: "GET",
                    url: url,
                    data: {
                        _token: "{{csrf_token()}}",
                    },
                    success: function (data) {
                        $('div#locations div div').empty();
                        $('div#devices div div').empty();
                        $('div#users div div').empty();
                        $('div#profiles div div').empty();

                        console.log(data);
                        data[0].forEach(function(item){
                            $('div#locations div div').append('<input name="locations['+item.id+']" class="tab-function" type="checkbox" >&nbsp;&nbsp;<label>'+item.description+'</label><br>');
                        });

                        console.log(data[1]);
                        data[1].forEach(function(item){
                            $('div#devices div div').append('<input name="devices['+item.id+']" class="tab-function" type="checkbox" >&nbsp;&nbsp;<label>'+item.description+'</label><br>');
                        });

                        console.log(data[2]);
                        data[2].forEach(function(item){
                            $('div#users div div').append('<input name="users['+item.id+']" class="tab-function" type="checkbox" >&nbsp;&nbsp;<label>'+item.name+' '+item.surname+'</label><br>');
                        });

                        console.log(data[3]);
                        data[3].forEach(function(item){
                            $('div#profiles div div').append('<input name="profiles['+item.id+']" class="tab-function" type="checkbox" >&nbsp;&nbsp;<label>'+item.name+'</label><br>');
                        });


                    }
                });
            })
            $('#select-brands').change();


        })


    </script>
@endsection