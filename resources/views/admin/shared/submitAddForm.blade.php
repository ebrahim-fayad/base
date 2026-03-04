<script>
    $(document).ready(function () {
        $(document).on('submit', '.store', function (e) {
            e.preventDefault();
            var url = $(this).attr('action')
            $.ajax({
                url: url,
                method: 'post',
                data: new FormData($(this)[0]),
                dataType: 'json',
                processData: false,
                contentType: false,
                beforeSend: function () {
                    $(".submit_button").html(
                        '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>'
                    ).attr('disabled', true)
                    // Clear jqBootstrapValidation messages
                    $('.store .help-block').remove()
                    $('.store .controls').find('.help-block').remove()
                    $('.store .controls').find('small').remove()
                    $('.store .controls').find('.invalid-feedback').remove()
                    $('.store input').removeClass('is-invalid')
                    $('.store select').removeClass('is-invalid')
                    $('.store textarea').removeClass('is-invalid')
                },
                success: function (response) {
                    $(".text-danger").remove()
                    $('.store input').removeClass('border-danger')
                    $(".submit_button").html("{{ __('admin.add') }}").attr(
                        'disabled', false)

                    if (response.key !== 'unauthorized') {
                        Swal.fire({
                            position: 'top-start',
                            type: 'success',
                            title: '{{ __('admin.added_successfully') }}',
                            showConfirmButton: false,
                            timer: 1500,
                            confirmButtonClass: 'btn btn-primary',
                            buttonsStyling: false,
                        })
                    }

                    setTimeout(function () {
                        window.location.replace(response.url)
                    }, 1000);
                },
                error: function (xhr) {
                    $(".submit_button").html("{{ __('admin.add') }}").attr(
                        'disabled', false)
                    // Clear all validation messages (both client-side and server-side)
                    $(".text-danger").remove()
                    $('.store .help-block').remove()
                    $('.store .controls').find('.help-block').remove()
                    $('.store .controls').find('small').remove()
                    $('.store .controls').find('.invalid-feedback').remove()
                    $('.store input').removeClass('border-danger').removeClass('is-invalid')
                    $('.store select').removeClass('border-danger').removeClass('is-invalid')
                    $('.store textarea').removeClass('border-danger').removeClass('is-invalid')

                    $.each(xhr.responseJSON.errors, function (key, value) {
                        var message = Array.isArray(value) ? value[0] : value;
                        // if kay has "." it means that input has two languages do this action to handle input name
                        if (key.indexOf(".") >= 0) {
                            var split = key.split('.')
                            key = split[0] + '\\[' + split[1] + '\\]'
                        }

                        $('.store .error.' + key).append(
                            `<span class="mt-5 text-danger">${message}</span>`);


                        // file inputs (image, logo, commercial_image)
                        if (key == 'image' || key == 'logo' || key == 'commercial_image') {
                            $('.store input[name^=' + key + ']').addClass(
                                'border-danger')
                            $('.store input[name^=' + key + '][type=file]').closest(
                                '.col-12')
                                .after(
                                    `<p class="text-danger text-center" style="margin-top: -10px">${message}</p>`
                                );
                        } else {
                            $('.store input[name^=' + key + ']').addClass(
                                'border-danger')
                            $('.store input[name^=' + key + '][type=file]').after(
                                `<span class="text-danger">${message}</span>`);
                        }


                        // normal inputs
                        $('.store input[name^=' + key + ']').addClass(
                            'border-danger')
                        $('.store input[name=' + key + '][type!=file]').after(
                            `<span class="text-danger">${message}</span>`);

                        // for textarea
                        $('.store textarea[name^=' + key + ']').addClass(
                            'border-danger')
                        $('.store textarea[name^=' + key + ']').after(
                            `<span class="mt-1 text-danger">${message}</span>`);
                        // for select input
                        $('.store select[name^=' + key + ']').addClass(
                            'border-danger')
                        $('.store select[name^=' + key + ']').after(
                            `<span class="mt-1 text-danger">${message}</span>`);
                    });
                },
            });

        });
    });
</script>
