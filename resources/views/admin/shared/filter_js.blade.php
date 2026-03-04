<script>
    getData()
    // input date js
    var $list = $(":input[type='date']");
        $(window).on('load', function() {
            if ($($list).length > 0) {
                $(document).find($list).addClass("custom-input-date");
                $(document).find($list).parents(".controls").addClass("parent-input-date");
            }

            var statrtLength        =   $('#start').length;
            var endLength           =   $('#start').length;


            if(statrtLength > 0 && endLength > 0){
                var start = flatpickr(document.querySelector('#start'), {
                    wrap: true,
                    disableMobile: true,
                    locale: "{{ app()->getLocale() }}",
                    dateFormat: "m-d-Y",
                    onChange: function(selectedDates, dateStr, instance) {
                        end.set('minDate', dateStr);
                    }
                });

                var end = flatpickr(document.querySelector('#end'), {
                    wrap: true,
                    disableMobile: true,
                    locale: "{{ app()->getLocale() }}",
                    dateFormat: "m-d-Y",
                    onChange: function(selectedDates, dateStr, instance) {
                        start.set('maxDate', dateStr);
                    }
                });
            }

        });


        $(".btn-searchTable").on("click", function(e) {
            e.stopPropagation();
            $(this).toggleClass("active");
            if ($(this).hasClass("active")) {
                $(".searchTable , .layout_").addClass("active");
            } else {
                $(".searchTable , .layout_").removeClass("active");
            }
        });

        $(".btnClose").on("click" , function () {
            $(".searchTable , .layout_").removeClass("active");
        });

        $(".layout_").on("click" , function () {
            $(".btn-searchTable.active").click();
        });

    function searchArray() {
        var searchArray = {} ;
        $('.search-input').each(function(key, input) {
            searchArray[$(this).attr('name')] = $(this).val()
        });
        return  searchArray
    }

    $(document).on('change', '.search-input', function (e) {
        e.preventDefault();
        getData({'searchArray' : searchArray()} )
    });

    $(document).on('click', '.reloadTable', function (e) {
        e.preventDefault();
        getData()
    });

    $(document).on('click', '.pagination a', function (e) {
        e.preventDefault();
        getData({page : $(this).attr('href').split('page=')[1]  , 'searchArray' : searchArray() } )
    });

    $('.table_loader').fadeOut('slow');


    function getData(array) {
        $.ajax({
            type: "get",
            url: "{{$index_route}}",
            data: array,
            dataType: "json",
            cache: false,
            beforeSend: function () {
                $('.table_loader').fadeIn('slow');
            },
            success: function (response) {
                let exportBtn = $("#export-btn"); // Select the <a> element
                $('.table_content_append').html(response.html)
                $('.table_loader').fadeOut('slow');
                if (response.modelCount == 0) {
                    exportBtn.addClass('d-none');
                } else {
                    exportBtn.removeClass('d-none');
                }
                let requestArray = $.param(array);
                let currentHref = exportBtn.attr("href"); // Get current href

                // Check if the href already has query parameters
                let updatedHref = currentHref.includes("?") ? `${currentHref}&${requestArray}` : `${currentHref}?${requestArray}`;
                // Update the href attribute
                exportBtn.attr("href", updatedHref);

            }
        });
    }

    $('.clean-input').on('click' ,function(){
        $(this).siblings('input').val(null);
        $(this).siblings('select').val(null);
        getData({'searchArray' : searchArray()} )
    });
</script>
