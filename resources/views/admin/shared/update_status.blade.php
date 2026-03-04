<script>
    $(document).on('click', '.toggle_approvement_status', function (e) {
        e.preventDefault();

        // لو الزر disabled ما يعملش أي حاجة
        if ($(this).hasClass('disabled')) return;

        const isApproved = $(this).data('action'); // 1 = active, 0 = inactive
        const id = $(this).data('id');

        sendStatusUpdate(id, isApproved, $(this));
    });

    function sendStatusUpdate(id, isApproved, $button) {
        $.ajax({
            url: "{{$route}}",
            method: 'post',
            data: {
                id: id,
                is_approved: isApproved,
                _token: '{{ csrf_token() }}'
            },
            beforeSend: function () {
                $button.addClass('disabled');
            },
            success: function (response) {
                Swal.fire({
                    position: 'top-start',
                    icon: 'success',
                    title: response.message,
                    showConfirmButton: false,
                    timer: 1200
                });

                // نحدّث الزرين بعد التغيير
                const $row = $button.closest('td');
                $row.find('.toggle_approvement_status').removeClass('disabled');
                $row.find(`[data-action="${isApproved}"]`).addClass('disabled');
            },
            error: function () {
                Swal.fire({
                    position: 'top-start',
                    icon: 'error',
                    title: '{{ __("admin.an_error_occurred") }}',
                    showConfirmButton: false,
                    timer: 1500
                });
            }
        });
    }
</script>