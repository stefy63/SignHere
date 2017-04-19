

<div class="modal inmodal" id="showModal" tabindex="-1"  role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated flipInY">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="modal-title" name="name"></h4>
            </div>
            <div class="modal-body">

                <div class="ibox-content">
                    <div class="row">
                        <div class="form-group">
                            <div class="col-md-3">
                                <label for="name" >{{__('admin_modules.db-name')}}</label>
                            </div>
                            <div class="col-md-7 col-md-offset-2">
                                <input class="form-control" size="50" type="text" name="name" value="{{old("name")}}" disabled />
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group">
                            <div class="col-md-3">
                                <label for="short_name" >{{__('admin_modules.db-short_name')}}</label>
                            </div>
                            <div class="col-md-7 col-md-offset-2">
                                <input class="form-control" size="50" type="text" name="short_name" value="{{old("short_name")}}" disabled />
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group">
                            <div class="col-md-3">
                                <label for="functions" >{{__('admin_modules.db-functions')}}</label>
                            </div>
                            <div class="col-md-7 col-md-offset-2">
                                <input class="form-control" size="50" type="text" name="functions" value="{{old("functions")}}" disabled />
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group">
                            <div class="col-md-3">
                                <label for="icon" >{{__('admin_modules.db-icon')}}</label>
                            </div>
                            <div class="col-md-7 col-md-offset-2">
                                <input class="form-control" size="50" type="text" name="icon" value="{{old("icon")}}" disabled />
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group">
                            <div class="col-md-3">
                                <label for="isadmin" >{{__('admin_modules.db-isadmin')}}</label>
                            </div>


                            <div class="col-md-7 col-md-offset-2">
                                <div class=" col-md-1 text-center"><i id="isadmin" name="isadmin" class="fa fa-dot-circle-o"></i> </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group">
                            <div class="col-md-3">
                                <label for="active" >{{__('admin_modules.db-active')}}</label>
                            </div>
                            <div class="col-md-7 col-md-offset-2">
                                <input class="js-switch-modal form-control" type="checkbox" data-switchery="true" name="active" value="1" @if(old("active") == 1) checked @endif style="display: none;" disabled />
                            </div>
                        </div>
                    </div>
                    <br>
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

    var elem = document.querySelector('.js-switch-modal');
    var switchery = new Switchery(elem);

    $('.open-modal').click(function(e){
        e.preventDefault();
        $('#showModal').modal('hide');
        var url = this.getAttribute('data-url');

        $.get(url, function (data) {
            data = data['0'];
            $('#showModal .modal-title').text(data['name']);
            for(var k in data) {
                if( k == 'isadmin') {
                    $('#showModal #isadmin').addClass((data[k] == 1)?'text-success':'text-danger');
                }

                if ($('#showModal input[name="' + k + '"]').attr('type') == 'checkbox') {
                    elem.checked = (data[k] == 1) ? true : false;
                    switchery.setAttributes('checked', (data[k] == 1) ? true : false);
                    switchery.handleOnchange(true);
                } else {
                    $('#showModal input[name="' + k + '"]').val(data[k]);
                }
            }
        })
    });
});
</script>