@extends('admin.back')
@push('scripts')
   <script src="{{ asset('js/summernote-lite.min.js') }}"></script>
   <script src="{{asset('js/lang/summernote-it-IT.js')}}"></script>
<script>
    $(function () {
        
        $('#summernote').summernote({
            placeholder: 'Inserisci il testo della mail',
            minHeight: 300,
            lang: 'it-IT',
            dialogsInBody: true,
            hint: {
                mentions: JSON.parse('{!! html_entity_decode($arFields) !!}'),
                match: /\B@(\w*)$/,
                search: function (keyword, callback) {
                  callback($.grep(this.mentions, function (item) {
                    return item.indexOf(keyword) == 0;
                  }));
                },
                content: function (item) {
                  return '{' + item + '}';
                }    
              }
          });
      });    
</script>
@endpush
@push('assets')
    <link href="{{ asset('css/summernote-lite.min.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>{{__('admin_mail_template.edit-title')}}</h5>
                <div ibox-tools="" class="ng-scope">
                    <div dropdown="" class="ibox-tools dropdown">
                        <a href="{{ url('admin_mail_template') }}"><button class="btn btn-primary dim"> <i class="fa fa-arrow-left"></i></button></a>
                    </div>
                </div>
            </div>
            <hr>

            <form method="POST" action="{{ route('admin_mail_template.update',['id' => $template->id]) }}"  id="toast-form">
                {!! csrf_field() !!}{{ method_field('PUT') }}
                
                <div class="row">
                    <div class="form-group">
                        <div class="col-md-2 col-md-offset-1">
                            <label for="brand_id" >{{__('admin_mail_template.db-brand_id')}}</label>
                        </div>
                        <div class="col-md-8">
                            <select class="form-control" name="brand_id">
                                 <option>{{__('admin_mail_template.db-select_brand') }}</option>
                                @foreach($brands as $brand)
                                 <option value="{{ $brand->id }}" @if($template->brand_id == $brand->id) selected @endif>{{ $brand->description}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="form-group">
                        <div class="col-md-2 col-md-offset-1">
                            <label for="name" >{{__('admin_mail_template.db-name')}}</label>
                        </div>
                        <div class="col-md-8">
                            <input class="form-control" size="50" type="text" name="name" value="{{$template->name}}" />
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group">
                        <div class="col-md-2 col-md-offset-1">
                            <label for="description" >{{__('admin_mail_template.db-description')}}</label>
                        </div>
                        <div class="col-md-8">
                            <input class="form-control" size="50" type="text" name="description" value="{{$template->description}}" />
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group">
                        <div class="col-md-2 col-md-offset-1">
                            <label for="active" >{{__('admin_mail_template.db-active')}}</label>
                        </div>
                        <div class="col-md-8">
                            <input class="js-switch" type="checkbox" data-switchery="true" name="active" value="1"  @if($template->active == 1) checked @endif style="display: none;"/>
                        </div>
                    </div>
                </div>
                <br>
                
                <div class="row">
                    <div class="form-group">
                        <div class="col-md-2 col-md-offset-1">
                            <label for="template" >{{__('admin_mail_template.db-text')}}</label>
                        </div>
                        <div class="col-md-8">
                            <h6 class="font-weight-light">Type @ for insert fields</h6>
                            <textarea id="summernote" name="template" >{{$template->template}}</textarea>
                        </div>
                    </div>
                </div>
                <br>

                <div class="row">
                    <div class="col-md-12 text-center">
                        <p><button class="submit-toast btn btn-block btn-outline btn-primary"  data-form-id="toast-form">{{__('admin_brands.submit')}}</button></p>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection