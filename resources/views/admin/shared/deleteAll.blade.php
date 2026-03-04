<script>
    $('.delete_all_button').hide()
    $(document).on('change', '#checkedAll', function() {
        if (this.checked) {
            // setTimeout(function (){
            $(".checkSingle").each(function(index, element) {
                this.checked = true;
                $('.delete_all_button').show()
            })
            // },500);
        } else {
            $(".checkSingle").each(function() {
                this.checked = false;
                $('.delete_all_button').hide()
            })
        }
    });
    $(document).on('click', '.checkSingle', function() {
        if ($(this).is(":checked")) {
            var isAllChecked = 0;
            $(".checkSingle").each(function() {
                if (!this.checked)
                    isAllChecked = 1;
            })
            if (isAllChecked == 0) {
                $("#checkedAll").prop("checked", true);
            }
            $('.delete_all_button').show()
        } else {
            var count = 0;
            $(".checkSingle").each(function() {
                if (this.checked)
                    count++;
            })
            if (count > 0) {
                $('.delete_all_button').show()
            } else {
                $('.delete_all_button').hide()
            }
            $("#checkedAll").prop("checked", false);
        }
    });
    $('.delete_all_button').on('click', function(e) {
        e.preventDefault()
        Swal.fire({
            title: "{{ __('admin.are_you_sure') }}",
            text: "{{ __('admin.are_you_sure_text') }}",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: '{{ __('admin.confirm') }}',
            confirmButtonClass: 'btn btn-primary',
            cancelButtonText: '{{ __('admin.cancel') }}',
            cancelButtonClass: 'btn btn-danger ml-1',
            buttonsStyling: false,
        }).then((result) => {
            if (result.value) {
                var usersIds = [];
                $('.checkSingle:checked').each(function() {
                    var id = $(this).attr('id');
                    usersIds.push({
                        id: id,
                    });
                });

                var requestData = JSON.stringify(usersIds);
                if (usersIds.length > 0) {
                    e.preventDefault();
                    $.ajax({
                        type: "POST",
                        url: $(this).data('route'),
                        data: {
                            data: requestData
                        },

                        success: function(response) {
                            if (response == 'success') {
                                $('.delete_all_button').hide()
                                Swal.fire({
                                    position: 'top-start',
                                    type: 'success',
                                    title: '{{ __('admin.the_selected_has_been_successfully_deleted') }}',
                                    showConfirmButton: false,
                                    timer: 1500,
                                    confirmButtonClass: 'btn btn-primary',
                                    buttonsStyling: false,
                                })
                                getData({
                                    'searchArray': searchArray()
                                })
                                // $('.checkSingle:checked').each(function () {
                                //     $('.data-list-view').DataTable().row($(this).closest('td').parent('tr')).remove().draw();
                                // });
                            } else {
                                $('.delete_all_button').hide()
                                Swal.fire({
                                    position: 'top-start',
                                    type: response.key ?? 'success',
                                    title: response.msg ??
                                        '{{ __('admin.the_selected_has_been_successfully_deleted') }}',
                                    showConfirmButton: false,
                                    timer: 1500,
                                    confirmButtonClass: 'btn btn-primary',
                                    buttonsStyling: false,
                                })
                                getData({
                                    'searchArray': searchArray()
                                })
                            }
                        }
                    });
                }
            }
        })
    });
</script>