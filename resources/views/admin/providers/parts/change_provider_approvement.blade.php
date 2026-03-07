@php use App\Enums\ApprovementStatusEnum; @endphp
<script>
    $(document).on('click', '.toggle_provider_status', function (e) {
        e.preventDefault();

        const actionStatus = $(this).data('action'); // APPROVED=1, REJECTED=2 مثلاً
        const providerId   = $(this).data('id');

        if (actionStatus === {{ ApprovementStatusEnum::REJECTED->value }}) {
            // Handle refusal (prompt for reason)
            Swal.fire({
                title: "{{ __('admin.the_written_text_of_the_refuse_reason') }}",
                input: 'textarea',
                inputPlaceholder: "{{ __('admin.enter_refuse_reason') }}",
                showCancelButton: true,
                cancelButtonText: "{{ __('admin.cancel') }}",
                confirmButtonText: "{{ __('admin.send') }}",
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                inputValidator: (value) => {
                    if (!value) {
                        return "{{ __('admin.enter_refuse_reason') }}";
                    }
                    if (value.trim().length < 3) {
                        return "{{ __('admin.please_enter_at_least_3_characters') }}";
                    }
                    if (value.trim().length > 255) {
                        return "{{ __('admin.please_enter_at_most_255_characters') }}";
                    }
                }
            }).then(function(result) {
                if (result.value) {
                    sendProviderStatusUpdate(providerId, actionStatus, result.value);
                }

            });
        } else if (actionStatus === {{ ApprovementStatusEnum::APPROVED->value }}) {
            // Handle approval directly
            sendProviderStatusUpdate(providerId, actionStatus);
        }
    });

    // Reusable function to send AJAX requests
    function sendProviderStatusUpdate(id, isApproved, refuseReason = null) {
        $.ajax({
            url: '{{ route('admin.providers.toggleApprovement') }}',
            method: 'post',
            data: {
                id: id,
                is_approved: isApproved,
                refuse_reason: refuseReason,
                _token: '{{ csrf_token() }}'
            },
            dataType: 'json',
            beforeSend: function () {
                $(`[data-id="${id}"]`).attr('disabled', true);
            },
            success: function (response) {
                Swal.fire({
                    position: 'top-start',
                    type: response.status,
                    title: response.message,
                    showConfirmButton: false,
                    timer: 1500,
                    confirmButtonClass: 'btn btn-primary',
                    buttonsStyling: false,
                });

                // Optionally reload data
                setTimeout(function () {
                    if (typeof getData === "function") {
                        getData();
                    } else {
                        if (refuseReason == null) {
                            location.reload();
                        } else {
                            // provider index page
                            window.location.href = '{{ route('admin.providers.index') }}';
                        }
                        
                    }
                }, 1000);


            },

            error: function (xhr, status, error) {
                Swal.fire({
                    position: 'top-start',
                    type: 'error',
                    title: '{{ __('admin.an_error_occurred') }}',
                    showConfirmButton: false,
                    timer: 1500,
                    confirmButtonClass: 'btn btn-primary',
                    buttonsStyling: false,
                });

            },
            complete: function () {
                $(`[data-id="${id}"]`).attr('disabled', false);
            }
        });
    }
</script>
