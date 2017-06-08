

<div class="modal inmodal" id="showModal" tabindex="-1"  role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated flipInY">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="modal-title" name="description">{{__('admin_users.update_resetPwd-title')}}</h4>
                <!--<small class="font-bold">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</small>-->
            </div>
            <div class="modal-body">

                <form method="POST" action="{{ route('admin_users.update_resetPwd')}}" id="toast-form">
                    {!! csrf_field() !!}
                    <input type="hidden" name="id" value="" />
                    <input type="hidden" name="user_id" value="{{Auth::user()->id}}" />

                    <div class="row">
                        <div class="form-group">
                            <div class="col-md-5 ">
                                <label for="new_password" >{{__('admin_users.new_password')}}</label>
                            </div>
                            <div class="col-md-6 col-md-offset-1">
                                <input class="form-control" size="50" type="password" name="new_password" value="" />
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="form-group">
                            <div class="col-md-5 ">
                                <label for="new_password_confirmation" >{{__('admin_users.new_password_confirmation')}}</label>
                            </div>
                            <div class="col-md-6 col-md-offset-1">
                                <input class="form-control" size="50" type="password" name="new_password_confirmation" value="" />
                            </div>
                        </div>
                    </div>
                    <br><br>

                    <div class="row">
                        <div class="col-md-12 text-center">
                            <p><button class="submit-toast btn btn-block btn-outline btn-primary" data-form-id="toast-form">{{__('admin_brands.submit')}}</button></p>
                        </div>
                    </div>
                </form>


            </div>
        </div>
    </div>
</div>
@push('scripts')
<script>
$(function(){

    //display modal form for task editing
    $('.open-modal').click(function(e){
        e.preventDefault();
        $('#showModal').modal('hide');
        var url = this.getAttribute('data-url');

        $.get(url, function (data) {
            //success data
            data = data['0'];
            $('#showModal .modal-title').text(data['description']);
            for(var k in data) {
                $('#showModal input[name="'+k+'"]').val(data[k]);
            }
        })
    });
});
</script>
@endpush