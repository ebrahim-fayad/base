<script>
    $(document).on('click', '.toggle_approvement_status', function(e) {
        e.preventDefault();

        const isApproved = $(this).data('action'); // 1 for approve, 2 for refuse
        const id = $(this).data('id');
        sendStatusUpdate(id, isApproved);
    });

    // Reusable function to send AJAX requests
    function sendStatusUpdate(id, isApproved, refuseReason = null) {
        $.ajax({
            url: "{{$route}}",
            method: 'post',
            data: {
                id: id,
                is_approved: isApproved,
                _token: '{{ csrf_token() }}'
            },
            dataType: 'json',
            beforeSend: function() {
                $(`[data-id="${id}"]`).attr('disabled', true);
            },
            success: function(response) {
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
                setTimeout(function() {
                    if (typeof getData === "function") {
                        getData();
                    } else {
                        location.reload();
                    }
                }, 1000);


            },

            error: function(xhr, status, error) {
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
            complete: function() {
                $(`[data-id="${id}"]`).attr('disabled', false);
            }
        });
    }
</script>
