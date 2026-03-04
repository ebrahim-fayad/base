<div class="modal fade text-left" id="replay" tabindex="-1" role="dialog" aria-labelledby="myModalLabel160"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary white">
                <h5 class="modal-title" id="myModalLabel160">{{ __('admin.the_replay') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.complaints.replay', ['id' => $row->id]) }}" method="POST"
                    enctype="multipart/form-data" class="notify-form">
                    @csrf
                    <div class="col-md-12 col-12">
                        <div class="form-group">
                            <label for="first-name-column">{{ __('admin.the_replay') }}</label>
                            <div class="controls">
                                <textarea name="replay" class="form-control" cols="30" complaints="10"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit"
                            class="btn btn-primary send-notify-button">{{ __('admin.send') }}</button>
                        <button type="button" class="btn btn-primary"
                            data-dismiss="modal">{{ __('admin.cancel') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
