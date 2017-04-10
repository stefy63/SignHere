@extends('admin.back')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>{{__('admin_acls.index-title')}}</h5>
                <div ibox-tools="" class="ng-scope">
                    <div dropdown="" class="ibox-tools dropdown">
                        <a href="{{ url('admin_acls/create') }}"> <i class="fa fa-plus-square-o"   data-toggle="tooltip" title="{{__('admin_acls.index-tooltip-create')}}"></i></a>
                    </div>
                </div>
            </div>
            <div class="ibox-content">
                <select class="form-control md" name="id" id="select-visibility" data-url="{{ url('admin_acls') }}">
                    @foreach($acls as $acl)
                        <option value="{{$acl->id}}">{{$acl->name}} - {{$acl->description}} </option>
                    @endforeach
                </select>
                <hr>
                <div class="tabs-container">
                    <div class="tabs-left">
                        <ul class="nav nav-tabs" >
                            <li class="active" id="tab-index">
                                <a data-toggle="tab" href="#brands">{{__('admin_brands.admin_brands')}}</a>
                            </li>
                            <li class="" id="tab-index">
                                <a data-toggle="tab" href="#locations">{{__('admin_locations.admin_locations')}}</a>
                            </li>
                            <li class="" id="tab-index">
                                <a data-toggle="tab" href="#devices">{{__('admin_devices.admin_devices')}}</a>
                            </li>
                            <li class="" id="tab-index">
                                <a data-toggle="tab" href="#users">{{__('admin_users.admin_users')}}</a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <!-- BRANDS TAB -->
                            <div id="brands" class="tab-pane active">
                                <div class="panel-body">
                                    <p class="text-center"><span>{{__('admin_acls.brands-panel-title')}}</span></p>
                                    <br>
                                    <div class="input-group m-b col-md-offset-2">
                                        <ul id="brands">

                                        </ul>
                                    </div>
                                    <br>
                                </div>
                            </div>
                            <!-- LOCATIONS TAB -->
                            <div id="locations" class="tab-pane">
                                <div class="panel-body">
                                    <p class="text-center"><span>{{__('admin_acls.locations-panel-title')}}</span></p>
                                    <br>
                                    <div class="input-group m-b col-md-offset-2">
                                        <ul id="locations">

                                        </ul>
                                    </div>
                                    <br>
                                </div>
                            </div>
                            <!-- LOCATIONS TAB-->
                            <div id="devices" class="tab-pane">
                                <div class="panel-body">
                                    <p class="text-center"><span>{{__('admin_acls.devices-panel-title')}}</span></p>
                                    <br>
                                    <div class="input-group m-b col-md-offset-2">
                                        <ul id="devices">

                                        </ul>
                                    </div>
                                    <br>
                                </div>
                            </div>
                            <!-- LOCATIONS TAB -->
                            <div id="users" class="tab-pane">
                                <div class="panel-body">
                                    <p class="text-center"><span>{{__('admin_acls.users-panel-title')}}</span></p>
                                    <br>
                                    <div class="input-group m-b col-md-offset-2">
                                        <ul id="users">

                                        </ul>
                                    </div>
                                    <br>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="text-center">
                            <button type="button" id="profile-edit" class="btn btn-w-m btn-primary button-toast" data-location="{{ url('admin_profiles/') }}">{{__('admin_profiles.btn-edit')}}</button>
                            <button type="button" id="profile-destroy" class="profile-action btn btn-w-m btn-danger confirm-toast" data-message="{{__('admin_profiles.index-confirm-message')}}" data-location="{{ url('admin_profiles/destroy/') }}">{{__('admin_profiles.btn-destroy')}}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
$(function () {

    $('#select-visibility').change(function (e) {
        e.preventDefault();
        var url = this.getAttribute('data-url');
        var acl = '/' + this.options[this.selectedIndex].value;
        url = url + acl;
        console.log(url);
        $.ajax({
            type: "GET",
            url: url,
            data: {
                _token: "{{csrf_token()}}",
            },
            success: function (data) {
                $('ul#brands').empty();
                $('ul#locations').empty();
                $('ul#devices').empty();
                $('ul#users').empty();

                console.log(data[0]);
                data[0].forEach(function(item){
                   $('ul#brands').append('<li> '+item.description+'</li>');
                });

                console.log(data[1]);
                data[1].forEach(function(item){
                    $('ul#locations').append('<li>  '+item.description+'</li>');
                });

                console.log(data[2]);
                data[2].forEach(function(item){
                    $('ul#devices').append('<li>  '+item.description+'</li>');
                });

                console.log(data[3]);
                data[3].forEach(function(item){
                    $('ul#users').append('<li> '+item.name+', '+item.surname+'</li>');
                });


            }
        });
    })
    $('#select-visibility').change();
})


</script>
@endsection