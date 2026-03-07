{{-- Export column selection modal - include in admin layout --}}
<div class="modal fade" id="export-column-modal" tabindex="-1" role="dialog" aria-labelledby="export-column-modal-title" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content export-column-modal-content">
            <div class="modal-header export-column-modal-header">
                <h5 class="modal-title" id="export-column-modal-title">{{ __('admin.export') }} – {{ __('admin.select_columns') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body export-column-modal-body">
                <p class="export-column-modal-description">{{ __('admin.select_columns_description') }}</p>
                <div class="export-column-actions">
                    <button type="button" class="btn btn-sm btn-outline-primary export-column-select-all" id="export-column-select-all">{{ __('admin.select_all') }}</button>
                    <button type="button" class="btn btn-sm btn-outline-secondary export-column-clear" id="export-column-clear">{{ __('admin.clear') }}</button>
                </div>
                <div class="export-column-loading text-center py-4" id="export-column-loading">
                    <span class="spinner-border spinner-border-sm" role="status"></span>
                    <span class="ml-2">{{ __('admin.loading_columns') }}</span>
                </div>
                <div class="export-column-error alert alert-danger d-none" id="export-column-error" role="alert"></div>
                <div class="export-column-grid" id="export-column-grid"></div>
            </div>
            <div class="modal-footer export-column-modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('admin.cancel') }}</button>
                <button type="button" class="btn btn-primary" id="export-column-submit">
                    <i class="fa fa-file-excel-o mr-1"></i> {{ __('admin.export_excel') }}
                </button>
            </div>
        </div>
    </div>
</div>

<style>
    .export-column-modal-content {
        border: none;
        border-radius: 12px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.12);
    }
    .export-column-modal-header {
        border-bottom: 1px solid #eee;
        padding: 1rem 1.25rem;
        background: #fafafa;
        border-radius: 12px 12px 0 0;
    }
    .export-column-modal-header .modal-title {
        font-weight: 600;
        color: #333;
        margin: 0;
    }
    .export-column-modal-header .close {
        margin: -0.5rem -0.5rem -0.5rem auto;
        font-size: 1.5rem;
        opacity: 0.6;
    }
    .export-column-modal-body {
        padding: 1.25rem 1.5rem;
    }
    .export-column-modal-description {
        color: #666;
        margin-bottom: 1rem;
        font-size: 0.95rem;
    }
    .export-column-actions {
        margin-bottom: 1rem;
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
    }
    .export-column-grid {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem 0.75rem;
        max-height: 320px;
        overflow-y: auto;
        padding: 0.25rem 0;
    }
    .export-column-option {
        display: flex;
        flex-direction: row;
        align-items: center;
        gap: 0.5rem;
        padding: 0.6rem 0.75rem;
        border-radius: 10px;
        cursor: pointer;
        transition: background 0.15s ease, border-color 0.15s ease;
        border: 1px solid #e0e0e0;
        background: #fafafa;
        min-width: 120px;
        flex: 0 0 auto;
    }
    .export-column-option:hover {
        background: #f0f4ff;
        border-color: #c5d9f8;
    }
    .export-column-option input {
        margin: 0;
        cursor: pointer;
        width: 1.15rem;
        height: 1.15rem;
        flex-shrink: 0;
        accent-color: #0a6ebd;
    }
    .export-column-option .export-column-label {
        margin: 0;
        font-size: 0.875rem;
        color: #333;
        line-height: 1.3;
        text-align: start;
        display: block;
        word-break: break-word;
    }
    .dark-layout .export-column-option {
        background: rgba(255,255,255,0.05);
        border-color: rgba(255,255,255,0.1);
    }
    .dark-layout .export-column-option:hover {
        background: rgba(255,255,255,0.1);
        border-color: rgba(255,255,255,0.2);
    }
    .dark-layout .export-column-option .export-column-label {
        color: #e4e4e7;
    }
    .export-column-modal-footer {
        border-top: 1px solid #eee;
        padding: 1rem 1.25rem;
        background: #fafafa;
        border-radius: 0 0 12px 12px;
    }
    .export-column-modal-footer .btn-primary {
        border-radius: 8px;
        padding: 0.5rem 1rem;
    }
    #export-column-loading.spinner-border {
        vertical-align: middle;
    }
    @media (max-width: 576px) {
        .export-column-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<script>
(function() {
    var modal = $('#export-column-modal');
    var grid = $('#export-column-grid');
    var loading = $('#export-column-loading');
    var errorEl = $('#export-column-error');
    var currentExportUrl = '';
    var currentColumns = {};

    function showLoading(show) {
        loading.toggle(show);
        grid.toggle(!show);
        errorEl.addClass('d-none');
    }

    function showError(msg) {
        loading.hide();
        grid.hide();
        errorEl.removeClass('d-none').text(msg || 'Failed to load columns.');
    }

    function renderCheckboxes(columns) {
        grid.empty();
        if (!columns || typeof columns !== 'object') return;
        Object.keys(columns).forEach(function(key) {
            var labelText = columns[key];
            var id = 'export-col-' + key.replace(/\./g, '-');
            var option = $('<label class="export-column-option"></label>').attr('for', id);
            option.append($('<input type="checkbox">').attr('id', id).addClass('export-column-cb').data('key', key));
            option.append($('<span class="export-column-label"></span>').text(labelText));
            grid.append(option);
        });
    }

    function getSelectedColumns() {
        var selected = [];
        $('.export-column-cb:checked').each(function() {
            selected.push($(this).data('key'));
        });
        return selected;
    }

    function setAll(checked) {
        $('.export-column-cb').prop('checked', checked);
    }

    $(document).on('click', '.export-btn', function(e) {
        var btn = $(this);
        if (!btn.attr('href')) return;
        e.preventDefault();
        currentExportUrl = btn.attr('href');
        var modelParam = btn.data('export');
        if (!modelParam) {
            var match = currentExportUrl.match(/[?&]model=([^&]+)/);
            if (match && match[1]) modelParam = decodeURIComponent(match[1].replace(/\+/g, ' '));
        }
        if (!modelParam) {
            showError('Export model not specified.');
            modal.modal('show');
            return;
        }
        currentColumns = {};
        grid.empty();
        errorEl.addClass('d-none');
        modal.modal('show');
        showLoading(true);

        var baseUrl = typeof window.appExportBaseUrl !== 'undefined' ? window.appExportBaseUrl : (window.location.origin + '/export');
        var columnsUrl = baseUrl + '/columns?model=' + encodeURIComponent(modelParam);

        $.ajax({
            url: columnsUrl,
            type: 'GET',
            dataType: 'json',
            success: function(res) {
                showLoading(false);
                if (res.columns && Object.keys(res.columns).length) {
                    currentColumns = res.columns;
                    renderCheckboxes(res.columns);
                    setAll(true);
                } else {
                    showError(res.message || 'No columns available.');
                }
            },
            error: function(xhr) {
                var msg = (xhr.responseJSON && xhr.responseJSON.message) ? xhr.responseJSON.message : 'Could not load columns.';
                showError(msg);
            }
        });
    });

    $('#export-column-select-all').on('click', function() { setAll(true); });
    $('#export-column-clear').on('click', function() { setAll(false); });

    $('#export-column-submit').on('click', function() {
        var selected = getSelectedColumns();
        if (selected.length === 0) {
            if (typeof toastr !== 'undefined') {
                toastr.warning('{{ __("admin.please_select_at_least_one_column") }}');
            } else {
                alert('{{ __("admin.please_select_at_least_one_column") }}');
            }
            return;
        }
        var sep = currentExportUrl.indexOf('?') >= 0 ? '&' : '?';
        var params = selected.map(function(c) { return 'columns[]=' + encodeURIComponent(c); }).join('&');
        var finalUrl = currentExportUrl + sep + params;
        modal.modal('hide');
        window.location.href = finalUrl;
    });
})();
</script>
