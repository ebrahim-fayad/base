<div role="tabpanel" class="tab-pane" id="general-settings" aria-labelledby="currency-pill-commission" aria-expanded="false">
    <form action="{{route('admin.settings.update')}}" method="post" enctype="multipart/form-data">
        @method('put')
        @csrf
        <div class="row">
            {{-- VAT and Commissions --}}
            <div class="col-12 col-md-4">
                <div class="form-group">
                    <label for="vat_ratio">{{__('admin.vat_ratio')}} (%)</label>
                    <div class="controls">
                        <input type="number" class="form-control" name="vat_ratio" id="vat_ratio"
                               placeholder="{{__('admin.vat_ratio')}}" max="100" min="0" step="0.01" value="{{$data['vat_ratio']}}">
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="form-group">
                    <label for="provider_commission_ratio">{{__('admin.provider_commission_ratio')}} (%)</label>
                    <div class="controls">
                        <input type="number" class="form-control" name="commission_from_providers" id="provider_commission_ratio"
                               placeholder="{{__('admin.provider_commission_ratio')}}" max="100" min="0" step="0.01" value="{{$data['commission_from_providers']}}">
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="form-group">
                    <label for="online_payment_fee">{{__('admin.online_payment_fee')}} (%)</label>
                    <div class="controls">
                        <input type="number" class="form-control" name="online_payment_fee" id="online_payment_fee"
                               placeholder="{{__('admin.online_payment_fee')}}" max="100" min="0" step="0.01" value="{{$data['online_payment_fee']}}">
                    </div>
                </div>
            </div>



            {{-- Contact Numbers Repeater --}}
            <div class="col-12">
                <hr>
                <div class="form-group">
                    <label class="d-block mb-1">{{ __('admin.contact_numbers') }}</label>
                    <div id="contact_numbers_container">
                        @foreach($data['contact_numbers'] as $index => $number)
                            <div class="contact-number-row mb-1">
                                <div class="input-group">
                                    <input type="text" name="contact_numbers[]" class="form-control"
                                           placeholder="{{ __('admin.enter_contact_number') }}" value="{{ $number }}">
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-danger remove-contact-number">
                                            <i class="feather icon-trash-2"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        @if(count($data['contact_numbers']) == 0)
                            <div class="contact-number-row mb-1">
                                <div class="input-group">
                                    <input type="text" name="contact_numbers[]" class="form-control"
                                           placeholder="{{ __('admin.enter_contact_number') }}">
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-danger remove-contact-number">
                                            <i class="feather icon-trash-2"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                    <button type="button" class="btn btn-outline-primary btn-sm mt-1" id="add_contact_number">
                        <i class="feather icon-plus"></i> {{ __('admin.add') }}
                    </button>
                </div>
                <hr>
            </div>

            {{-- Notification Sound Section --}}
            <div class="col-12">
                <div class="form-group">
                    <label class="font-weight-bold">{{ __('admin.notification_sound') }}</label>
                    <div class="row align-items-end">
                        <div class="col-md-6">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" name="notification_sound" id="notification_sound" accept="audio/*">
                                <label class="custom-file-label" for="notification_sound">{{ __('admin.choose') }}</label>
                            </div>
                        </div>
                        <div class="col-md-6 mt-2 mt-md-0">
                            @if(!empty($data['notification_sound']))
                            {{-- {{  }} dd(asset($data['notification_sound'])) }} --}}
                                <div class="card bg-light-primary border-primary mb-0 shadow-sm overflow-hidden" style="border-radius: 12px;">
                                    <div class="card-body p-1">
                                        <div class="d-flex align-items-center">
                                            <div class="icon-wrapper bg-primary text-white p-1 rounded-circle mr-2 shadow-sm d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                                                <i class="feather icon-music font-medium-3"></i>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="mb-0 font-small-3">{{ __('admin.current_notification_sound') }}</h6>
                                                <audio id="current_notification_audio" controls class="w-100 mt-50" style="height: 35px;">
                                                    <source src="{{ asset($data['notification_sound']) }}">
                                                </audio>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <div id="new_notification_sound_wrapper" style="display: none;">
                                <div class="card bg-light-success border-success mb-0 shadow-sm overflow-hidden mt-1 animate__animated animate__fadeIn" style="border-radius: 12px;">
                                    <div class="card-body p-1">
                                        <div class="d-flex align-items-center">
                                            <div class="icon-wrapper bg-success text-white p-1 rounded-circle mr-2 shadow-sm d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                                                <i class="feather icon-play font-medium-3"></i>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="mb-0 font-small-3 text-success">{{ __('admin.new_notification_sound_preview') }}</h6>
                                                <audio id="new_notification_audio" controls class="w-100 mt-50" style="height: 35px;"></audio>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 d-flex justify-content-center mt-3">
                <button type="submit" class="btn btn-primary mr-1 mb-1 submit_button">{{__('admin.saving_changes')}}</button>
                <a href="{{ url()->previous() }}" type="reset" class="btn btn-outline-warning mr-1 mb-1">{{__('admin.back')}}</a>
            </div>
        </div>

        <style>
            .bg-light-primary { background-color: rgba(115, 103, 240, 0.12) !important; }
            .bg-light-success { background-color: rgba(40, 199, 111, 0.12) !important; }
            audio::-webkit-media-controls-panel { background-color: rgba(255, 255, 255, 0.8); }
            .contact-number-row .input-group { box-shadow: 0 2px 4px rgba(0,0,0,0.05); border-radius: 5px; overflow: hidden; }
        </style>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                // Audio Preview Logic
                var input = document.getElementById('notification_sound');
                if (input) {
                    input.addEventListener('change', function (e) {
                        var file = e.target.files[0];
                        if (!file) return;

                        var fileName = file.name;
                        var label = e.target.nextElementSibling;
                        if (label) label.innerText = fileName;

                        var audioWrapper = document.getElementById('new_notification_sound_wrapper');
                        var audio = document.getElementById('new_notification_audio');
                        if (!audioWrapper || !audio) return;

                        var url = URL.createObjectURL(file);
                        audio.src = url;
                        audioWrapper.style.display = 'block';
                        audio.play().catch(function () {});
                    });
                }

                // Contact Numbers Repeater Logic
                var container = document.getElementById('contact_numbers_container');
                var addButton = document.getElementById('add_contact_number');

                if (addButton && container) {
                    addButton.addEventListener('click', function() {
                        var newRow = document.createElement('div');
                        newRow.className = 'contact-number-row mb-1 animate__animated animate__fadeInDown';
                        newRow.innerHTML = `
                            <div class="input-group">
                                <input type="text" name="contact_numbers[]" class="form-control"
                                       placeholder="{{ __('admin.enter_contact_number') }}">
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-danger remove-contact-number">
                                        <i class="feather icon-trash-2"></i>
                                    </button>
                                </div>
                            </div>
                        `;
                        container.appendChild(newRow);

                        // Add event listener to the new remove button
                        newRow.querySelector('.remove-contact-number').addEventListener('click', function() {
                            newRow.remove();
                        });
                    });

                    // Add event listeners to existing remove buttons
                    container.querySelectorAll('.remove-contact-number').forEach(function(button) {
                        button.addEventListener('click', function() {
                            if (container.querySelectorAll('.contact-number-row').length > 1) {
                                button.closest('.contact-number-row').remove();
                            } else {
                                button.closest('.contact-number-row').querySelector('input').value = '';
                            }
                        });
                    });
                }
            });
        </script>
    </form>
</div>
