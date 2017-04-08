@extends('admin.back')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>{{__('admin_profiles.index-title')}}</h5>
                <div ibox-tools="" class="ng-scope">
                    <div dropdown="" class="ibox-tools dropdown">
                        <a href="{{ url('admin_profiles/create') }}"> <i class="fa fa-plus-square-o"   data-toggle="tooltip" title="{{__('admin_profiles.index-tooltip-create')}}"></i></a>
                    </div>
                </div>
            </div>
            <div class="ibox-content">
                <select class="form-control md" name="id" id="select-profile" data-url="{{ url('admin_profiles') }}">
                    @foreach($profiles as $profile)
                        <option value="{{$profile->id}}">{{$profile->name}}</option>
                    @endforeach
                </select>
                <hr>
                <div class="tabs-container">
                    <div class="tabs-left">
                        <ul class="nav nav-tabs" >
                            @foreach($modules as $module)
                                <li class="@if($module->id == 1) active @endif" id="tab-index">
                                    <a data-toggle="tab" href="#mod-{{$module->id}}">{{__($module->short_name.".".$module->short_name)}}</a>
                                </li>
                            @endforeach
                        </ul>
                        <div class="tab-content">
                            @foreach($modules as $module)
                                <div id="mod-{{$module->id}}" class="tab-pane @if($module->id == 1) active @endif">
                                    <div class="panel-body">
                                        <p class="text-center"><span>Elenco funzioni</span></p><br>
                                        @php
                                            $functions = explode(',',$module->functions);
                                        @endphp
                                        @foreach($functions as $function)
                                            <div class="input-group m-b">
                                                <span class="input-group-addon">
                                                    <input name="{{$function}}" class="tab-function" type="checkbox" disabled>
                                                </span>
                                                <input type="text" class="form-control" value="{{__('admin_profiles.crud-'.$function)}}" disabled />
                                            </div>
                                        @endforeach
                                        <br>
                                    </div>
                                </div>
                            @endforeach
                            <div class="text-center">
                                <button type="button" id="profile-submit" class="profile-action btn btn-w-m btn-success submit-toast" data-message="{{__('admin_profiles.btn-submit')}}" data-location="{{ url('admin_profiles/') }}" hidden>{{__('admin_profiles.btn-submit')}}</button>
                                <button type="button" id="profile-edit" class="btn btn-w-m btn-primary" data-location="{{ url('admin_profiles/') }}">{{__('admin_profiles.btn-edit')}}</button>
                                <button type="button" id="profile-destroy" class="profile-action btn btn-w-m btn-danger confirm-toast" data-message="{{__('admin_profiles.index-confirm-message')}}" data-location="{{ url('admin_profiles/destroy/') }}">{{__('admin_profiles.btn-destroy')}}</button>
                            </div>
                        </div>
                    </div>
                </div>



            </div>
        </div>
    </div>
</div>
<script>
$(function () {

    $('#select-profile').change(function (e) {
        e.preventDefault();
        $('input[type="checkbox"]').prop('disabled', true);
        $('#profile-submit').hide();
        var url = this.getAttribute('data-url');
        var profile = '/' + this.options[this.selectedIndex].value;
        $('.tab-function').each(function (elem) {
            this.checked = false;
        });
        $('#profile-submit').attr('data-location',url+profile);
        $('#profile-edit').attr('data-location',url+profile+'/edit');
        $('#profile-destroy').attr('data-location',url+'/destroy'+profile);
        url = url + profile;

        $.ajax({
            type: "GET",
            url: url,
            data: {
                _token: "{{csrf_token()}}",
            },
            success: function (data) {

                data.forEach(function(module){
                    module.forEach(function (field) {
                        $('#mod-'+field.id+' .tab-function').each(function (elem) {
                            var func = this.getAttribute('name');
                            var perm = field.pivot.permission;
                            if(perm.indexOf(func) >= 0 || perm.indexOf('ALL') >= 0) {
                                this.checked = true;
                            } else {
                                this.checked = false;
                            }
                        });
                    })
                });
                //toastr['success']('', data['success']);
            }
        });
    });
    $('#select-profile').change();

    $('#profile-edit').click(function () {
        $('input[type="checkbox"]').prop('disabled', false);
        $('#profile-submit').fadeIn();
        var url = this.getAttribute('data-url');
        
    })






})

</script>

@endsection