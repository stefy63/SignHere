@extends('admin.back')

@section('content')
<div>

    <form method="POST" action="{{ route('admin_doctypes.store') }}" id="toast-form">
    {!! csrf_field() !!}

        <div class="row">
            <div class="form-group">
                <div class="col-md-2 col-md-offset-1">
                    <label for="name" >{{__('admin_doctypes.db-name')}}</label>
                </div>
                <div class="col-md-8">
                    <input class="form-control" size="50" type="text" name="name" value="{{old("name")}}" />
                </div>
            </div>
        </div>

        <div class="row">
            <div class="form-group">
                <div class="col-md-2 col-md-offset-1">
                    <label for="description" >{{__('admin_doctypes.db-description')}}</label>
                </div>
                <div class="col-md-8">
                    <input class="form-control" size="50" type="text" name="description" value="{{old("description")}}" />
                </div>
            </div>
        </div>

        <div class="row">
            <div class="form-group">
                <div class="col-md-2 col-md-offset-1">
                    <label for="template" >{{__('admin_doctypes.db-template')}}</label>
                </div>
                <div class="col-md-8">
                    <input class="form-control" size="50" type="text" name="template" value="{{old("template")}}" />
                </div>
            </div>
        </div>

        <div class="row">
            <div class="form-group">
                <div class="col-md-2 col-md-offset-1">
                    <label for="active" >{{__('admin_doctypes.db-active')}}</label>
                </div>
                <div class="col-md-8">
                    <input class="js-switch form-control" type="checkbox" data-switchery="true" name="active" value="1" @if(old("active") == 1) checked @endif style="display: none;" />
                </div>
            </div>
        </div>
        <br>

        <div class="row">
            <div class="col-md-12 text-center">
                <p><button class="submit-toast btn btn-block btn-outline btn-primary" data-form-id="toast-form">{{__('admin_brands.submit')}}</button></p>
            </div>
        </div>
    </form>

</div>
@endsection