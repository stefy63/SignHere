@extends('admin.back')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>{{__('admin_acls.edit-title')}}</h5>
                <div ibox-tools="" class="ng-scope">
                    <div dropdown="" class="ibox-tools dropdown">
                        <a href="{{ url('admin_acls') }}"><button class="btn btn-primary dim"> <i class="fa fa-arrow-left"></i></button></a>
                    </div>
                </div>
            </div>
            <form method="POST" action="{{ route('admin_acls.update',['id' => $acl->id]) }}" id="toast-form" style="background-color: white">
                {!! csrf_field() !!}{{ method_field('PUT') }}
                <div class="">
                    <br>
                    <div class="">
                        <div class="col-md-2 col-md-offset-1">
                            <label for="name" >{{__('admin_acls.db-name')}}</label>
                        </div>
                        <div class="col-md-8">
                            <input class="form-control" size="50" type="text" name="name" value="{{$acl->name}}" />
                        </div>
                    </div>
                    <div class="">
                        <div class="col-md-2 col-md-offset-1">
                            <label for="description" >{{__('admin_acls.db-description')}}</label>
                        </div>
                        <div class="col-md-8">
                            <input class="form-control" size="50" type="text" name="description" value="{{$acl->description}}" />
                        </div>
                    </div>
                    <div class="">
                        <div class="col-md-2 col-md-offset-1">
                            <label for="brand" >{{__('admin_acls.db-select-brands')}}</label>
                        </div>
                        <div class="col-md-8">
                            <select class="form-control col-md-8" name="brand_id" id="select-brands" data-url="{{ url('admin_acls/store_getitem') }}">
                                @foreach($brands as $brand)
                                    <option class="form-control col-md-8" value="{{$brand->id}}" @if($brand->id == $acl->brands()->first()->pivot->brand_id) selected @endif>{{$brand->description}} </option>
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
                                @foreach($parent as $val)
                                    <option class="form-control col-md-8" value="{{$val->id}}" @if($val->id == $acl->parent_id) selected @endif>{{$val->name}} </option>
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
                                <!--<li class="" id="tab-index">
                                    <a data-toggle="tab" href="#devices">{{__('admin_devices.admin_devices')}}</a>
                                </li>-->
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
                                <!-- DEVICES TAB
                                <div id="devices" class="tab-pane">
                                    <div class="panel-body">
                                        <p class="text-center"><span>{{__('admin_acls.devices-panel-title')}}</span></p>
                                        <br>
                                        <div class="input-group m-b col-md-offset-3"></div>
                                        <br>
                                    </div>
                                </div>-->
                                <!-- USERS TAB -->
                                <div id="users" class="tab-pane">
                                    <div class="panel-body">
                                        <p class="text-center"><span>{{__('admin_acls.users-panel-title')}}</span></p>
                                        <br>
                                        <div class="input-group m-b col-md-offset-3"></div>
                                        <br><br><br>
                                            <button type="button" class="btn btn-outline btn-danger btn-xs pull-right" id="clear-users" ><small>{{__('admin_acls.users-panel-clear')}}</small></button>
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
                    <button type="button" class="btn btn-w-m btn-success submit-toast" data-form-id="toast-form" data-message="{{__('admin_acls.btn-submit')}}">{{__('admin_acls.btn-submit')}}</button>
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
                console.log(data);
                $('div#locations div div').empty();
                $('div#devices div div').empty();
                $('div#users div div').empty();
                $('div#profiles div div').empty();
                var arLocations = JSON.parse('{{$acl->locations()->get()->pluck('id')}}');
                var arDevides = JSON.parse('{{$acl->devices()->get()->pluck('id')}}');
                var arUsers = JSON.parse('{{$acl->users()->get()->pluck('id')}}');
                var arProfiles = JSON.parse('{{$acl->profiles()->get()->pluck('id')}}');

                console.log(data[0]);
                data[0].forEach(function(item){
                    $('div#locations div div').append('<input name="locations['+item.id+']" class="tab-function" type="checkbox" ' +((arLocations.indexOf(item.id)!=-1)?'checked':'') +
                        '>&nbsp;&nbsp;<label>'+item.description+'</label><br>');
                });

                console.log(data[1]);
                data[1].forEach(function(item){
                    $('div#devices div div').append('<input name="devices['+item.id+']" class="tab-function" type="checkbox" ' +((arDevides.indexOf(item.id)!=-1)?'checked':'') +
                        '>&nbsp;&nbsp;<label>'+item.description+'</label><br>');
                });

                console.log(data[2]);
                console.log(arUsers);
                data[2].forEach(function(item){
                    $('div#users div div').append('<input name="users['+item.id+']" class="tab-function users" type="checkbox" ' + ((arUsers.indexOf(item.id)!=-1)?'checked':'') +
                    ' >&nbsp;&nbsp;<label>'+item.name+' '+item.surname+'</label><br>');
                });

                console.log(data[3]);
                data[3].forEach(function(item){
                    $('div#profiles div div').append('<input name="profiles['+item.id+']" class="tab-function" type="checkbox" ' +((arProfiles.indexOf(item.id)!=-1)?'checked':'') +
                        '>&nbsp;&nbsp;<label>'+item.name+'</label><br>');
                });


            }
        });
    })
    $('#select-brands').change();

    $('#clear-users').click(function(e){
        e.preventDefault();
        var form = $('#toast-form');
        $('.users').removeAttr('checked');
        console.log(form.prop('action'));
        form.submit();
    });

})
</script>
@endsection