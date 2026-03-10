<script>
    window.formRequestLocks = window.formRequestLocks || {};

    function setButtonLoadingState($button) {
        if (!$button || !$button.length) {
            return;
        }

        if (!$button.data('original-html')) {
            $button.data('original-html', $button.html());
        }

        $button
            .html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>')
            .prop('disabled', true)
            .addClass('is-loading');
    }

    function resetButtonLoadingState($button) {
        if (!$button || !$button.length) {
            return;
        }

        var originalHtml = $button.data('original-html');
        if (originalHtml) {
            $button.html(originalHtml);
        }

        $button.prop('disabled', false).removeClass('is-loading');
    }

    $(document).ready(function () {
        $(document).on('submit', '.store', function (e) {
            e.preventDefault();

            var $form = $(this);
            var key = ($form.attr('action') || '') + '::' + ($form.attr('method') || 'POST');
            var now = Date.now();

            // Optional safety throttle: ignore submits within 2s for same form
            if (window.formRequestLocks[key] && now - window.formRequestLocks[key] < 2000) {
                return;
            }

            if ($form.data('is-submitting')) {
                return;
            }

            $form.data('is-submitting', true);
            window.formRequestLocks[key] = now;

            var $submitButton = $form.find('.submit_button');
            setButtonLoadingState($submitButton);

            var url = $form.attr('action');

            $.ajax({
                url: url,
                method: 'post',
                data: new FormData($form[0]),
                dataType: 'json',
                processData: false,
                contentType: false,
                beforeSend: function () {
                    // Clear jqBootstrapValidation messages
                    $form.find('.help-block').remove();
                    $form.find('.controls').find('.help-block').remove();
                    $form.find('.controls').find('small').remove();
                    $form.find('.controls').find('.invalid-feedback').remove();
                    $form.find('input').removeClass('is-invalid');
                    $form.find('select').removeClass('is-invalid');
                    $form.find('textarea').removeClass('is-invalid');
                },
                success: function (response) {
                    $(".text-danger").remove();
                    $form.find('input').removeClass('border-danger');

                    resetButtonLoadingState($submitButton);
                    $form.data('is-submitting', false);

                    if (response.key !== 'unauthorized') {
                        Swal.fire({
                            position: 'top-start',
                            type: 'success',
                            title: '{{ __('admin.added_successfully') }}',
                            showConfirmButton: false,
                            timer: 1500,
                            confirmButtonClass: 'btn btn-primary',
                            buttonsStyling: false,
                        });
                    }

                    setTimeout(function () {
                        window.location.replace(response.url);
                    }, 1000);
                },
                error: function (xhr) {
                    resetButtonLoadingState($submitButton);
                    $form.data('is-submitting', false);
                    window.formRequestLocks[key] = Date.now();

                    // Clear all validation messages (both client-side and server-side)
                    $(".text-danger").remove();
                    $form.find('.help-block').remove();
                    $form.find('.controls').find('.help-block').remove();
                    $form.find('.controls').find('small').remove();
                    $form.find('.controls').find('.invalid-feedback').remove();
                    $form.find('input').removeClass('border-danger').removeClass('is-invalid');
                    $form.find('select').removeClass('border-danger').removeClass('is-invalid');
                    $form.find('textarea').removeClass('border-danger').removeClass('is-invalid');

                    $.each(xhr.responseJSON.errors, function (key, value) {
                        var message = Array.isArray(value) ? value[0] : value;
                        // if key has "." it means that input has two languages do this action to handle input name
                        if (key.indexOf(".") >= 0) {
                            var split = key.split('.');
                            key = split[0] + '\\[' + split[1] + '\\]';
                        }

                        $form.find('.error.' + key).append(
                            `<span class="mt-5 text-danger">${message}</span>`
                        );

                        // file inputs (image, logo, commercial_image)
                        if (key == 'image' || key == 'logo' || key == 'commercial_image') {
                            $form.find('input[name^=' + key + ']').addClass('border-danger');
                            $form
                                .find('input[name^=' + key + '][type=file]')
                                .closest('.col-12')
                                .after(
                                    `<p class="text-danger text-center" style="margin-top: -10px">${message}</p>`
                                );
                        } else {
                            $form.find('input[name^=' + key + ']').addClass('border-danger');
                            $form
                                .find('input[name^=' + key + '][type=file]')
                                .after(`<span class="text-danger">${message}</span>`);
                        }

                        // normal inputs
                        $form.find('input[name^=' + key + ']').addClass('border-danger');
                        $form
                            .find('input[name=' + key + '][type!=file]')
                            .after(`<span class="text-danger">${message}</span>`);

                        // for textarea
                        $form.find('textarea[name^=' + key + ']').addClass('border-danger');
                        $form
                            .find('textarea[name^=' + key + ']')
                            .after(`<span class="mt-1 text-danger">${message}</span>`);

                        // for select input
                        $form.find('select[name^=' + key + ']').addClass('border-danger');
                        $form
                            .find('select[name^=' + key + ']')
                            .after(`<span class="mt-1 text-danger">${message}</span>`);
                    });
                },
            });
        });
    });
</script>
