

<div class="modal inmodal" id="showModal" tabindex="-1"  role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated flipInY">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="modal-title" name="description"></h4>
            </div>
            <div class="modal-body">


                    <div class="row">
                        <div class="form-group">
                            <div class="col-md-5 ">
                                <label for="serial" >{{__('admin_devices.index-header-col-2')}}</label>
                            </div>
                            <div class="col-md-6 col-md-offset-1">
                                <input class="form-control" size="50" type="text" name="serial" value="" disabled/>
                            </div>
                        </div>
                    </div>

                    <br><br>

                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                </div>


            </div>
        </div>
    </div>
</div>
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