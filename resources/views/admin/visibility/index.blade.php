@extends('admin.back')

@section('content')
@push('scripts')
<script src="{{ asset('js/plugins/jsTree/jstree.min.js') }}"></script>
@endpush
@push('assets')
<link href="{{ asset('css/plugins/jsTree/style.min.css') }}" rel="stylesheet">
@endpush
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
                <!--<select class="form-control md" name="id" id="select-visibility" data-url="{{ url('admin_acls') }}">
                    @foreach($acls as $acl)
                        <option value="{{$acl->id}}">{{$acl->name}} - {{$acl->description}} </option>
                    @endforeach
                </select>
                <hr>-->
                <div class="tabs-container">
                    <div class="tab-content col-md-3" id="tree_div"data-url="{{ url('admin_acls') }}">{!! $tree !!}</div>
                    <div class="col-md-9">
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
                            <li class="" id="tab-index">
                                <a data-toggle="tab" href="#profiles">{{__('admin_profiles.admin_profiles')}}</a>
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
                            <!-- PROFILES TAB -->
                            <div id="profiles" class="tab-pane">
                                <div class="panel-body">
                                    <p class="text-center"><span>{{__('admin_acls.profiles-panel-title')}}</span></p>
                                    <br>
                                    <div class="input-group m-b col-md-offset-2">
                                        <ul id="profiles">

                                        </ul>
                                    </div>
                                    <br>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="text-center">
                            <button type="button" id="acl-edit" class="btn btn-w-m btn-primary button-toast" data-location="{{ url('admin_acls/') }}">{{__('admin_acls.btn-edit')}}</button>
                            <button type="button" id="acl-destroy" class="profile-action btn btn-w-m btn-danger confirm-toast" data-message="{{__('admin_profiles.index-confirm-message')}}" data-location="{{ url('admin_acls/destroy/') }}">{{__('admin_acls.btn-destroy')}}</button>
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
        $('#acl-edit').attr('data-location',url+acl+'/edit');
        $('#acl-destroy').attr('data-location',url+'/destroy'+acl);
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
                $('ul#profiles').empty();

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

                console.log(data[4]);
                data[4].forEach(function(item){
                    $('ul#profiles').append('<li> '+item.name+'</li>');
                });

            }
        });
    })
    $('#select-visibility').change();


    $('#tree_div').jstree({
        "core" : {
            "themes" : {
                "variant" : "small",
            },
            "expand_selected_onload":true,
        },
    });

    $('#tree_div').on("changed.jstree", function (e, data) {
        console.log(data.selected[0]);
        e.preventDefault();
        var url = this.getAttribute('data-url');
        var acl = '/' + data.selected[0];
        $('#acl-edit').attr('data-location',url+acl+'/edit');
        $('#acl-destroy').attr('data-location',url+'/destroy'+acl);
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
                $('ul#profiles').empty();

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

                console.log(data[4]);
                data[4].forEach(function(item){
                    $('ul#profiles').append('<li> '+item.name+'</li>');
                });
            }
        });
    });
    $('#tree_div ul :first-child').trigger('click');

})


</script>
@endsection