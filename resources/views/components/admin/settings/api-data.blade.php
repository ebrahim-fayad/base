<div role="tabpanel" class="tab-pane" id="account-vertical-api"
     aria-labelledby="account-pill-api" aria-expanded="false">
    <form accept="{{route('admin.settings.update')}}" method="post"
          enctype="multipart/form-data">
        @method('put')
        @csrf
        <div class="row">

            <div class="col-12 col-md-6">
                <div class="form-group">
                    <div class="controls">
                        <label for="account-name">{{__('admin.live_chat')}}</label>
                        <input type="text" class="form-control" name="live_chat"
                               id="account-name"
                               placeholder="{{__('admin.live_chat')}}"
                               value="{{$data['live_chat']}}">
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6">
                <div class="form-group">
                    <div class="controls">
                        <label for="account-name">{{__('admin.google_analytics')}}</label>
                        <input type="text" class="form-control"
                               name="google_analytics" id="account-name"
                               placeholder="{{__('admin.google_analytics')}}"
                               value="{{$data['google_analytics']}}">
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6">
                <div class="form-group">
                    <div class="controls">
                        <label for="account-name">{{__('admin.google_places')}}</label>
                        <input type="text" class="form-control" name="google_places"
                               id="account-name"
                               placeholder="{{__('admin.google_places')}}"
                               value="{{$data['google_places']}}">
                    </div>
                </div>
            </div>

            <div class="col-12 d-flex justify-content-center mt-3">
                <button type="submit"
                        class="btn btn-primary mr-1 mb-1 submit_button">{{__('admin.saving_changes')}}</button>
                <a href="{{ url()->previous() }}" type="reset"
                   class="btn btn-outline-warning mr-1 mb-1">{{__('admin.back')}}</a>
            </div>
        </div>
    </form>
</div>