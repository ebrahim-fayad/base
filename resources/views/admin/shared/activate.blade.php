<script>
    $(document).ready(function() {
        $(document).on('click', '.activate', function(e) {
            e.preventDefault();
            $.ajax({
                url:"{{$route}}",
                method: 'post',
                data: {
                    id: $(this).data('id')
                },
                dataType: 'json',
                beforeSend: function() {
                    $(this).html(
                        '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>'
                    ).attr('disable', true)
                },
                success: function(response) {
                    Swal.fire({
                        position: 'top-start',
                        type: response.key,
                        title: response.message,
                        showConfirmButton: false,
                        timer: 1500,
                        confirmButtonClass: 'btn btn-primary',
                        buttonsStyling: false,
                    })
                    if (response.key === 'success') {
                        setTimeout(function() {
                            getData();
                        }, 1000);
                    }
                },
            });

        });
    });
</script>
