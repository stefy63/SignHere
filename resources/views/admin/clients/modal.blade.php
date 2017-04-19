

<div class="modal inmodal" id="showModal" tabindex="-1"  role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated flipInY">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="modal-title" name="name"></h4>
                <!--<small class="font-bold">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</small>-->
            </div>
            <div class="modal-body">

                <div class="row">
                    <div class="form-group">
                        <div class="col-md-3 col-md-offset-1">
                            <label for="email" >{{__('admin_brands.db-email')}}</label>
                        </div>
                        <div class="col-md-7 col-md-offset-1">
                            <input class="form-control" size="50" type="text" name="email" value="" disabled/>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group">
                        <div class="col-md-3 col-md-offset-1">
                            <label for="vat" >{{__('admin_brands.db-vat')}}</label>
                        </div>
                        <div class="col-md-7 col-md-offset-1">
                            <input class="form-control" size="50" type="text" name="vat" value="" disabled/>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group">
                        <div class="col-md-3 col-md-offset-1">
                            <label for="personal_vat" >{{__('admin_brands.db-personal_vat')}}</label>
                        </div>
                        <div class="col-md-7 col-md-offset-1">
                            <input class="form-control" size="50" type="text" name="personal_vat" value="" disabled/>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group">
                        <div class="col-md-3 col-md-offset-1">
                            <label for="address" >{{__('admin_brands.db-address')}}</label>
                        </div>
                        <div class="col-md-7 col-md-offset-1">
                            <input class="form-control" size="50" type="text" name="address" value="" disabled/>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group">
                        <div class="col-md-3 col-md-offset-1">
                            <label for="city" >{{__('admin_brands.db-city')}}</label>
                        </div>
                        <div class="col-md-7 col-md-offset-1">
                            <input class="form-control" size="50" type="text" name="city" value="" disabled/>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group">
                        <div class="col-md-3 col-md-offset-1">
                            <label for="zip_code" >{{__('admin_brands.db-zip_code')}}</label>
                        </div>
                        <div class="col-md-7 col-md-offset-1">
                            <input class="form-control" size="50" type="text" name="zip_code" value="" disabled/>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group">
                        <div class="col-md-3 col-md-offset-1">
                            <label for="region" >{{__('admin_brands.db-region')}}</label>
                        </div>
                        <div class="col-md-7 col-md-offset-1">
                            <input class="form-control" size="50" type="text" name="region" value="" disabled/>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group">
                        <div class="col-md-3 col-md-offset-1">
                            <label for="contact" >{{__('admin_brands.db-contact')}}</label>
                        </div>
                        <div class="col-md-7 col-md-offset-1">
                            <input class="form-control" size="50" type="text" name="contact" value="" disabled/>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group">
                        <div class="col-md-3 col-md-offset-1">
                            <label for="phone" >{{__('admin_brands.db-phone')}}</label>
                        </div>
                        <div class="col-md-7 col-md-offset-1">
                            <input class="form-control" size="50" type="text" name="phone" value="" disabled/>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group">
                        <div class="col-md-3 col-md-offset-1">
                            <label for="mobile" >{{__('admin_brands.db-mobile')}}</label>
                        </div>
                        <div class="col-md-7 col-md-offset-1">
                            <input class="form-control" size="50" type="text" name="mobile" value="" disabled/>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <p>
                    <div class="form-group">
                        <div class="col-md-2 col-md-offset-1">
                            <label for="active" >{{__('admin_brands.db-active')}}</label>
                        </div>
                        <div class="col-md-6 col-md-offset-2">
                            <input class="js-switch-modal" type="checkbox" data-switchery="true" name="active" checked disabled readonly style="..."/>
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
<script>
$(function(){

    var elem = document.querySelector('.js-switch-modal');
    var switchery = new Switchery(elem);

    $('.open-modal').click(function(e){
        e.preventDefault();
        $('#showModal').modal('hide');
        var url = this.getAttribute('data-url');


        $.get(url, function (data) {
            //success data
            data = data['0'];
            $('#showModal .modal-title').text(data['surname']+" "+data['name']);
            for(var k in data) {
                if($('#showModal input[name="'+k+'"]').attr('type') == 'checkbox') {
                    switchery.isChecked((data[k] == 1)? true:false);
                    //$('#showModal input[name="'+k+'"]').prop('checked',(data[k] == 1)? false:true);
                    //$('#showModal input[name="'+k+'"]').click();

                } else {
                    $('#showModal input[name="'+k+'"]').val(data[k]);
                }
            }
        })
    });
});
</script>