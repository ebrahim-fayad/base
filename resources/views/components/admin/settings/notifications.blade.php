<div role="tabpanel" class="tab-pane" id="account-vertical-notifications" aria-labelledby="account-pill-notifications" aria-expanded="false">
    <form accept="{{route('admin.settings.update')}}" method="post" enctype="multipart/form-data">
        @method('put')
        @csrf
        <div class="row">
            <div class="col-12 col-md-6">
                <div class="form-group">
                    <div class="controls">
                        <label for="account-name">{{__('admin.sender_identification')}}</label>
                        <input type="text" class="form-control" name="firebase_sender_id" id="account-name" placeholder="{{__('admin.sender_identification')}}" value="{{$data['firebase_sender_id']}}">
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
