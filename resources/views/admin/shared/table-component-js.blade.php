{{--
  Table component JS: Select-all for dynamically loaded rows.
  Use delegated events so it works after AJAX injects table HTML.
  Include once per layout (e.g. in master or with filter_js).
--}}
<script>
(function() {
    'use strict';

    // Select all checkbox: works with dynamically loaded table content
    $(document).on('change', '#checkedAll', function() {
        var isChecked = this.checked;
        $('.table_content_append .checkSingle').each(function() {
            this.checked = isChecked;
        });
        $(document).trigger('table-checkboxes-changed');
    });

    // Single row checkbox: update "select all" state
    $(document).on('change', '.table_content_append .checkSingle', function() {
        var $container = $(this).closest('.table_content_append');
        var total = $container.find('.checkSingle').length;
        var checked = $container.find('.checkSingle:checked').length;
        $container.find('#checkedAll').prop('checked', total > 0 && checked === total);
        $(document).trigger('table-checkboxes-changed');
    });

    // After AJAX load: uncheck "select all" (new content)
    $(document).on('table-content-loaded', function() {
        $('#checkedAll').prop('checked', false);
    });
})();
</script>
