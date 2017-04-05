@extends('admin.back')

@section('content')

        <form method="POST" action="{{ route('admin_doctypes.update',['id' => $doctype->id]) }}"  id="toast-form">
            {!! csrf_field() !!}{{ method_field('PUT') }}

            <div class="row">
                <div class="form-group">
                    <div class="col-md-2 col-md-offset-1">
                        <label for="name" >{{__('admin_doctypes.db-name')}}</label>
                    </div>
                    <div class="col-md-8">
                        <input class="form-control" size="50" type="text" name="name" value="{{$doctype->name}}" />
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="form-group">
                    <div class="col-md-2 col-md-offset-1">
                        <label for="description" >{{__('admin_doctypes.db-description')}}</label>
                    </div>
                    <div class="col-md-8">
                        <input class="form-control" size="50" type="text" name="description" value="{{$doctype->description}}" />
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="form-group">
                    <div class="col-md-2 col-md-offset-1">
                        <label for="template" >{{__('admin_doctypes.db-template')}}</label>
                    </div>
                    <div class="col-md-8">
                        <input class="form-control" size="50" type="text" name="template" value="{{$doctype->template}}" />
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="form-group">
                    <div class="col-md-2 col-md-offset-1">
                        <label for="active" >{{__('admin_doctypes.db-active')}}</label>
                    </div>
                    <div class="col-md-8">
                        <input class="js-switch" type="checkbox" data-switchery="true" name="active" value="1"  @if($doctype->active == 1) checked @endif style="display: none;"/>
                    </div>
                </div>
            </div>
            <br><br>



            <div class="row">
                <div class="col-md-12 text-center">
                    <p><button class="submit-toast btn btn-block btn-outline btn-primary"  data-form-id="toast-form">{{__('admin_doctypes.submit')}}</button></p>
                </div>
            </div>
        </form>

    </div>
@endsection