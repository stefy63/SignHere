

<div class="modal inmodal" id="showModal" tabindex="-1"  role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated flipInY">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="modal-title" name="name"></h4>
            </div>
            <div class="modal-body">

                    <div class="row">
                        <div class="form-group">
                            <div class="col-md-3 ">
                                <label for="description" >{{__('admin_doctypes.index-header-col-2')}}</label>
                            </div>
                            <div class="col-md-9">
                                <input class="form-control" size="50" type="text" name="description" value="" disabled/>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group">
                            <div class="col-md-3 ">
                                <label for="template" >{{__('admin_doctypes.index-header-col-3')}}</label>
                            </div>
                            <div class="col-md-9">
                                <textarea class="form-control" cols="50" rows="3" name="template" readonly style="resize: vertical;"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group">
                            <div class="col-md-3 ">
                                <label for="questions" >{{__('admin_doctypes.db-questions')}}</label>
                            </div>
                            <div class="col-md-9">
                                <textarea class="form-control" cols="50" rows="3" name="questions" readonly style="resize: vertical;"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <p>
                        <div class="form-group">
                            <div class="col-md-5 ">
                                <label for="single_sign" >{{__('admin_doctypes.db-single_sign')}}</label>
                            </div>
                            <div class="col-md-7">
                                <input class="js-switch-modal2" type="checkbox" data-switchery="true" name="single_sign" checked disabled style="..." />
                            </div>
                        </div>
                        </p>
                    </div>

                    <div class="row">
                        <p>
                        <div class="form-group">
                            <div class="col-md-5 ">
                                <label for="active" >{{__('admin_doctypes.db-active')}}</label>
                            </div>
                            <div class="col-md-7">
                                <input class="js-switch-modal" type="checkbox" data-switchery="true" name="active" checked disabled style="..." />
                            </div>
                        </div>
                        </p>
                    </div>
                    <br><br>

                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                </div>


            </div>
        </div>
    </div>
</div>
@push('scripts')
<script>
$(function(){

    var elem = document.querySelector('.js-switch-modal');
    var switchery = new Switchery(elem);
    var elem2 = document.querySelector('.js-switch-modal2');
    var switchery2 = new Switchery(elem2);

    $('.open-modal').click(function(e){
        e.preventDefault();
        $('#showModal').modal('hide');
        var url = this.getAttribute('data-url');

        $.get(url, function (data) {
            //success data
            data = data['0'];
            $('#showModal .modal-title').text(data['name']);
            for(var k in data) {
                if ($('#showModal input[name="' + k + '"]').attr('type') == 'checkbox') {
                    var jswitch = $('#showModal input[name="' + k + '"]');
                    $(jswitch).prop('disabled', false);
                    $(jswitch).prop('checked',(data[k] == 1)? true:false);
                    if (k == 'active') {
                        switchery.setAttributes('checked',(data[k] == 1)? true:false);
                        switchery.handleOnchange(true);
                    } else {
                        switchery2.setAttributes('checked',(data[k] == 1)? true:false);
                        switchery2.handleOnchange(true);
                    }
                    $(jswitch).prop('disabled', true);
                } else {
                    if(k == 'template' || k == 'questions')
                        $('#showModal textarea[name="' + k + '"]').text(data[k]);
                    else
                        $('#showModal input[name="' + k + '"]').val(data[k]);
                }
            }
        })
    });
});
</script>
@endpush