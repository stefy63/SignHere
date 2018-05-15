@extends('admin.back')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>{{__('admin_profiles.index-title')}}</h5>
                <div ibox-tools="" class="ng-scope">
                    <div dropdown="" class="ibox-tools dropdown">
                        @if(Auth::user()->hasRole('admin_profiles','create'))
                        <a href="{{ url('admin_profiles/create') }}"><button class="btn btn-primary dim"> <i class="fa fa-plus"   data-toggle="tooltip" title="{{__('admin_profilesindex-tooltip-create')}}"></i> {{__('admin_brands.index-new')}}</button></a>
                        @endif
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
                                        <p class="text-center"><span>{{__('admin_profiles.index-subtitle')}}</span></p><br>
                                        @php
                                            $functions = explode(',',$module->functions);
                                        @endphp
                                        @foreach($functions as $function)
                                            <div class="input-group m-b">
                                                <span class="input-group-addon">
                                                    <input name="{{$function}}" class="tab-function" type="checkbox" disabled>
                                                </span>
                                                <!--<input type="text" class="form-control" value="{{__('admin_profiles.crud-'.$function)}}" disabled />-->
                                                <label class="form-control"><i>{{__($module->short_name.'.crud-'.$function)}}</i></label>
                                            </div>
                                        @endforeach
                                        <br>
                                    </div>
                                </div>
                            @endforeach
                            <div class="text-center">
                                @if(Auth::user()->hasRole('admin_profiles','edit'))<button type="button" id="profile-edit" class="btn btn-w-m btn-primary button-toast" data-location="{{ url('admin_profiles/') }}">{{__('admin_profiles.btn-edit')}}</button>@endif
                                @if(Auth::user()->hasRole('admin_profiles','destroy'))<button type="button" id="profile-destroy" class="profile-action btn btn-w-m btn-danger confirm-toast" data-message="{{__('admin_profiles.index-confirm-message')}}" data-location="{{ url('admin_profiles/destroy/') }}">{{__('admin_profiles.btn-destroy')}}</button>endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script>
$(function () {

    $('#select-profile').change(function (e) {
        e.preventDefault();
        $('input[type="checkbox"]').prop('disabled', true);
        //$('#profile-submit').hide();
        var url = this.getAttribute('data-url');
        var profile = '/' + this.options[this.selectedIndex].value;
        $('.tab-function').each(function (elem) {
            this.checked = false;
        });
        $('#profile-edit').attr('data-location',url+profile+'/edit');
        $('#profile-destroy').attr('data-location',url+'/destroy'+profile);
        $('input#name').val(this.options[this.selectedIndex].text);
        url = url + profile;
console.log(url);
        $.ajax({
            type: "GET",
            url: url,
            data: {
                _token: "{{csrf_token()}}",
            },
            success: function (data) {
                console.log(data);
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


})

</script>
@endpush
@endsection