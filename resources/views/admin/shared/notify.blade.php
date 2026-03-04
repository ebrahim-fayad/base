<script>
    $(document).on('click', '.mail', function(e) {
        $('.notify_id').val($(this).data('id'))
        $('.notify_user_type').val($(this).data('type'))
    })
</script>
<script>
    $(document).on('click', '.notify', function(e) {
        $('.notify_id').val($(this).data('id'))
        $('.notify_user_type').val($(this).data('type'))
    })
</script>
<script>
    $(document).ready(function() {
        // عند إغلاق مودال الإشعار (X أو إلغاء) افرغ الحقول
        $('#notify').on('hidden.bs.modal', function() {
            $('#notify .notify-form')[0]?.reset();
            $('#notify .error').empty();
            $('#notify .form-control').removeClass('border-danger');
        });

        $(document).on('submit', '.notify-form', function(e) {
            e.preventDefault();
            var url = $(this).attr('action')
            $.ajax({
                url: url,
                method: 'post',
                data: new FormData($(this)[0]),
                dataType: 'json',
                processData: false,
                contentType: false,
                beforeSend: function() {
                    $(".send-notify-button").html(
                        '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>'
                    ).attr('disable', true)
                },
                success: function(response) {
                    $(".text-danger").remove()
                    $('.store input').removeClass('border-danger')
                    $(".send-notify-button").html("{{ __('admin.send') }}").attr('disable',
                        false)
                    if (response.key !== 'unauthorized') {
                        Swal.fire({
                            position: 'top-start',
                            type: 'success',
                            title: '{{ __('admin.send_successfully') }}',
                            showConfirmButton: false,
                            timer: 1500,
                            confirmButtonClass: 'btn btn-primary',
                            buttonsStyling: false,
                        })
                        setTimeout(function() {
                            window.location.reload()
                        }, 1000);
                    }
                },
                error: function(xhr) {
                    $(".send-notify-button").html("{{ __('admin.send') }}").attr(
                        'disable',
                        false)
                    $(".text-danger").remove()
                    $('.store input').removeClass('border-danger')

                    $.each(xhr.responseJSON.errors, function(key, value) {
                        $('.store input[name=' + key + ']').addClass(
                            'border-danger')
                        $('.store input[name=' + key + ']').after(
                            `<span class="mt-5 text-danger">${value}</span>`
                        );
                        $('.store select[name=' + key + ']').after(
                            `<span class="mt-5 text-danger">${value}</span>`
                        );
                        $('.notify-form textarea[name=' + key + ']').after(
                            `<span class="mt-5 text-danger">${value}</span>`
                        );
                        $('.notify-form input[name=' + key + ']').after(
                            `<span class="mt-5 text-danger">${value}</span>`
                        );
                    });
                },
            });

        });
    });
</script>
