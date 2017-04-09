@extends('admin.back')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>{{__('admin_acls.index-title')}}</h5>
                <div ibox-tools="" class="ng-scope">
                    <div dropdown="" class="ibox-tools dropdown">
                        <a href="{{ url('admin_profiles/create') }}"> <i class="fa fa-plus-square-o"   data-toggle="tooltip" title="{{__('admin_profiles.index-tooltip-create')}}"></i></a>
                    </div>
                </div>
            </div>
            <div class="ibox-content">
            @foreach($acls as $acl)
            <ul>
                <li>{{$acl->name}}</li>
                <li>
                <ul>
                @foreach($acl->brands()->where('active',true)->get() as $brand)
                    <li>{{$brand->description}}</li>
                @endforeach
                </ul></li><li><ul>
                @foreach($acl->locations()->where('active',true)->get() as $location)
                    <li>{{$location->description}}</li>
                @endforeach
                </ul>
                </li>
            </ul>
            @endforeach
            </div>
        </div>
    </div>
</div>
<script>



</script>

@endsection