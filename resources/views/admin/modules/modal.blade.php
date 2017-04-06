

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
                                <div class="onoffswitch" >
                                    <input type="checkbox" name="isadmin" class="onoffswitch-checkbox" @if(old("isadmin") == 1) checked @endif id="check1" disabled />
                                    <label class="onoffswitch-label" for="check1">
                                        <span class="onoffswitch-inner"></span>
                                        <span class="onoffswitch-switch"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group">
                            <div class="col-md-3">
                                <label for="active" >{{__('admin_modules.db-active')}}</label>
                            </div>
                            <div class="col-md-7 col-md-offset-2">
                                <input class="js-switch form-control" type="checkbox" data-switchery="true" name="active" value="1" @if(old("active") == 1) checked @endif style="display: none;" disabled />
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

    //display modal form for task editing
    $('.open-modal').click(function(e){
        e.preventDefault();
        $('#showModal').modal('hide');
        var url = this.getAttribute('data-url');

        $.get(url, function (data) {
            //success data
            data = data['0'];
            $('#showModal .modal-title').text(data['name']);
            for(var k in data) {
                $('#showModal input[name="'+k+'"]').val(data[k]);
            }
        })
    });
});
</script>