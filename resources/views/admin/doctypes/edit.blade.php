@extends('admin.back')

@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>{{__('admin_doctypes.edit-title')}}</h5>
                <div ibox-tools="" class="ng-scope">
                    <div dropdown="" class="ibox-tools dropdown">
                        <a href="{{ url('admin_doctypes') }}"><span class="badge badge-info"> <i class="fa fa-arrow-left"></i></span></a>
                    </div>
                </div>
            </div>
            <hr>

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
                            <textarea class="form-control" cols="50" rows="3" name="template">{{$doctype->template}}</textarea>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group">
                        <div class="col-md-2 col-md-offset-1">
                            <label for="questions" >{{__('admin_doctypes.db-questions')}}</label>
                        </div>
                        <div class="col-md-8">
                            <textarea class="form-control" cols="50" rows="3" name="questions">{{$doctype->questions}}</textarea>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group">
                        <div class="col-md-2 col-md-offset-1">
                            <label for="single_sign" >{{__('admin_doctypes.db-single_sign')}}</label>
                        </div>
                        <div class="col-md-8">
                            <input class="js-switch-single_sign" type="checkbox" data-switchery="true" name="single_sign" value="1"  @if($doctype->single_sign == 1) checked @endif style="display: none;"/>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group">
                        <div class="col-md-2 col-md-offset-1">
                            <label for="active" >{{__('admin_doctypes.db-active')}}</label>
                        </div>
                        <div class="col-md-8">
                            <input class="js-switch-active" type="checkbox" data-switchery="true" name="active" value="1"  @if($doctype->active == 1) checked @endif style="display: none;"/>
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
    </div>
</div>

<script>
$(function() {

    var elem_1 = document.querySelector('.js-switch-single_sign');
    var switchery_1 = new Switchery(elem_1, {color: '#1AB394'});

    var elem_2 = document.querySelector('.js-switch-active');
    var switchery_2 = new Switchery(elem_2, {color: '#1AB394'});

});

</script>
@endsection