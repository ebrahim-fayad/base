<div role="tabpanel" class="tab-pane" id="account-vertical-smtp" aria-labelledby="account-pill-smtp" aria-expanded="false">
    <form accept="{{route('admin.settings.update')}}" method="post" enctype="multipart/form-data">
        @method('put')
        @csrf
        <div class="row">

            <div class="col-12 col-md-6">
                <div class="form-group">
                    <div class="controls">
                        <label for="account-name">{{__('admin.user_name')}}</label>
                        <input type="text" class="form-control" name="smtp_user_name" id="account-name" placeholder="{{__('admin.user_name')}}" value="{{$data['smtp_user_name']}}">
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6">
                <div class="form-group">
                    <div class="controls">
                        <label for="account-name">{{__('admin.password')}}</label>
                        <input type="password" class="form-control" name="smtp_password" id="account-name" placeholder="{{__('admin.password')}}" value="{{$data['smtp_password']}}">
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6">
                <div class="form-group">
                    <div class="controls">
                        <label for="account-name">{{__('admin.email_Sender')}}</label>
                        <input type="text" class="form-control" name="smtp_mail_from" id="account-name" placeholder="{{__('admin.email_Sender')}}" value="{{$data['smtp_mail_from']}}">
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6">
                <div class="form-group">
                    <div class="controls">
                        <label for="account-name">{{__('admin.the_sender_name')}}</label>
                        <input type="text" class="form-control" name="smtp_sender_name" id="account-name" placeholder="{{__('admin.the_sender_name')}}" value="{{$data['smtp_sender_name']}}">
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="form-group">
                    <div class="controls">
                        <label for="account-name">{{__('admin.the_nouns_al')}}</label>
                        <input type="text" class="form-control" name="smtp_host" id="account-name" placeholder="{{__('admin.the_nouns_al')}}" value="{{$data['smtp_host']}}">
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6">
                <div class="form-group">
                    <div class="controls">
                        <label for="account-name">{{__('admin.encryption_type')}}</label>
                        <input type="text" class="form-control" name="smtp_encryption" id="account-name" placeholder="{{__('admin.encryption_type')}}" value="{{$data['smtp_encryption']}}">
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6">
                <div class="form-group">
                    <div class="controls">
                        <label for="account-name">{{__('admin.Port_number')}}</label>
                        <input type="number" class="form-control" name="smtp_port" id="account-name" placeholder="{{__('admin.Port_number')}}" value="{{$data['smtp_port']}}">
                    </div>
                </div>
            </div>

            <div class="col-12 d-flex justify-content-center mt-3">
                <button type="submit" class="btn btn-primary mr-1 mb-1 submit_button">{{__('admin.saving_changes')}}</button>
                <a href="{{ url()->previous() }}" type="reset" class="btn btn-outline-warning mr-1 mb-1">{{__('admin.back')}}</a>
            </div>
        </div>
    </form>
</div>