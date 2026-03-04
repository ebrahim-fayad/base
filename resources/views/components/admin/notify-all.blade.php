<div class="modal fade text-left" id="notify" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel160">{{__('admin.Send_notification')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{$route}}" method="POST" enctype="multipart/form-data" class="notify-form">
                    @csrf
                    <input type="hidden" name="id" class="notify_id">
                    <input type="hidden" name="user_type" class="notify_user_type" >
                    <input type="hidden" name="type" class="notify" value="notify">
                    <div class="row">

                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label for="first-name-column">{{__('admin.the_title_in_arabic')}}</label>
                                <div class="controls">
                                    <input name="title_ar" type="text" required class="form-control" oninput="this.setCustomValidity('')"
                                        oninvalid='this.setCustomValidity("{{ __('admin.this_field_is_required') }}")' />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label for="first-name-column">{{__('admin.the_title_in_english')}}</label>
                                <div class="controls">
                                    <input name="title_en" type="text" required class="form-control" oninput="this.setCustomValidity('')"
                                        oninvalid='this.setCustomValidity("{{ __('admin.this_field_is_required') }}")' />
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label for="first-name-column">{{__('admin.the_message_in_arabic')}}</label>
                                <div class="controls">
                                    <textarea name="body_ar" required class="form-control" cols="30" rows="10" oninput="this.setCustomValidity('')"
                                        oninvalid='this.setCustomValidity("{{ __('admin.this_field_is_required') }}")'></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label for="first-name-column">{{__('admin.the_message_in_english')}}</label>
                                <div class="controls">
                                    <textarea name="body_en" required class="form-control" cols="30" rows="10" oninput="this.setCustomValidity('')"
                                        oninvalid='this.setCustomValidity("{{ __('admin.this_field_is_required') }}")'></textarea>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary send-notify-button" >{{__('admin.send')}}</button>
                        <button type="button" class="btn btn-primary" data-dismiss="modal">{{__('admin.cancel')}}</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

<div class="modal fade text-left" id="mail" tabindex="-1" role="dialog" aria-labelledby="myModalLabel160" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary white">
                <h5 class="modal-title" id="myModalLabel160">{{__('admin.Send_email')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{$route}}" method="POST" enctype="multipart/form-data" class="notify-form">
                    @csrf
                    <input type="hidden" name="id" class="notify_id">
                    <input type="hidden" name="user_type" class="notify_user_type" >
                    <input type="hidden" name="type" class="email" value="email">
                    <div class="col-md-12 col-12">
                        <div class="form-group">
                            <label for="first-name-column">{{__('admin.the_written_text_of_the_email')}}</label>
                            <div class="controls">
                                <textarea name="body" class="form-control" cols="30" rows="10"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary send-notify-button" >{{__('admin.send')}}</button>
                        <button type="button" class="btn btn-primary" data-dismiss="modal">{{__('admin.cancel')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
