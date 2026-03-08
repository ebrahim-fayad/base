{{-- Export column selection modal - include in admin layout - v3.0 --}}
<div class="modal fade" id="export-column-modal" tabindex="-1" role="dialog" aria-labelledby="export-column-modal-title" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content export-column-modal-content">
            <div class="modal-header export-column-modal-header">
                <h5 class="modal-title" id="export-column-modal-title">{{ __('admin.export') }} - {{ __('admin.select_columns') }}</h5>
                <button type="button" class="close export-column-close" data-dismiss="modal" aria-label="Close">
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
    /* CSS Variables for Light and Dark Mode */
    #export-column-modal {
        --card-bg-light: #ffffff;
        --card-bg-dark: #1f2937;
        --export-modal-bg: var(--card-bg-light);
        --export-modal-border: #e5e7eb;
        --export-modal-text: #111827;
        --export-modal-text-muted: #6b7280;
        --export-modal-accent: #4f46e5;
        --export-modal-selected-border: #8fb0ff;
        --export-modal-selected-bg: #f3f7ff;
        --export-modal-hover-border: #c7d7fe;
        --export-modal-shadow: 0 20px 50px rgba(0, 0, 0, 0.15);
        --export-modal-card-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        --export-modal-card-hover-shadow: 0 4px 12px rgba(79, 70, 229, 0.15);
        --export-modal-card-selected-shadow: 0 4px 16px rgba(79, 70, 229, 0.25);
    }

    body.dark-layout #export-column-modal,
    body[data-theme="dark"] #export-column-modal {
        --export-modal-bg: var(--card-bg-dark);
        --export-modal-border: #374151;
        --export-modal-text: #f9fafb;
        --export-modal-text-muted: #9ca3af;
        --export-modal-accent: #818cf8;
        --export-modal-selected-border: #818cf8;
        --export-modal-selected-bg: rgba(129, 140, 248, 0.15);
        --export-modal-hover-border: rgba(129, 140, 248, 0.4);
        --export-modal-shadow: 0 20px 50px rgba(0, 0, 0, 0.5);
        --export-modal-card-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
        --export-modal-card-hover-shadow: 0 4px 12px rgba(129, 140, 248, 0.3);
        --export-modal-card-selected-shadow: 0 4px 16px rgba(129, 140, 248, 0.4);
    }

    #export-column-modal .modal-dialog {
        max-width: 900px;
    }

    #export-column-modal .modal-content {
        background: var(--export-modal-bg) !important;
    }

    /* Remove backdrop completely */
    #export-column-modal + .modal-backdrop,
    #export-column-modal.show + .modal-backdrop,
    .modal-backdrop.show,
    .modal-backdrop.fade,
    .modal-backdrop {
        display: none !important;
        opacity: 0 !important;
        visibility: hidden !important;
    }

    body.dark-layout #export-column-modal + .modal-backdrop,
    body[data-theme="dark"] #export-column-modal + .modal-backdrop,
    body.dark-layout #export-column-modal.show + .modal-backdrop,
    body[data-theme="dark"] #export-column-modal.show + .modal-backdrop,
    body.dark-layout .modal-backdrop.show,
    body[data-theme="dark"] .modal-backdrop.show,
    body.dark-layout .modal-backdrop,
    body[data-theme="dark"] .modal-backdrop {
        display: none !important;
        opacity: 0 !important;
        visibility: hidden !important;
    }

    /* Unified Card Background - Single Color */
    .export-column-modal-content {
        overflow: hidden;
        border: 1px solid var(--export-modal-border) !important;
        border-radius: 12px !important;
        background: var(--export-modal-bg) !important;
        box-shadow: var(--export-modal-shadow) !important;
    }

    /* Header with Flexbox Layout */
    .export-column-modal-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 24px;
        border-bottom: 1px solid var(--export-modal-border);
        background: var(--export-modal-bg) !important;
        border-top: none !important;
        border-left: none !important;
        border-right: none !important;
    }

    .export-column-modal-header .modal-title {
        margin: 0;
        font-size: 1.25rem;
        font-weight: 600;
        color: var(--export-modal-text) !important;
        line-height: 1.4;
        flex: 1;
    }

    /* Close Button */
    .export-column-close {
        display: flex !important;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        margin: 0 !important;
        padding: 0 !important;
        border: 2px solid #d1d5db !important;
        border-radius: 8px;
        background: #ffffff !important;
        color: #374151 !important;
        font-size: 1.75rem;
        line-height: 1;
        opacity: 1 !important;
        transition: all 0.2s ease;
        font-weight: 300;
    }

    body.dark-layout .export-column-close,
    body[data-theme="dark"] .export-column-close {
        border-color: #4b5563 !important;
        background: #374151 !important;
        color: #f9fafb !important;
    }

    .export-column-close span {
        display: block;
        line-height: 1;
        margin-top: -2px;
    }

    .export-column-close:hover {
        background: #ef4444 !important;
        color: #ffffff !important;
        border-color: #ef4444 !important;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.4) !important;
    }

    .export-column-close:active {
        transform: translateY(0);
    }

    .export-column-modal-body {
        padding: 24px;
        background: var(--export-modal-bg) !important;
    }

    .export-column-modal-description {
        color: var(--export-modal-text-muted) !important;
        margin-bottom: 1.25rem;
        font-size: 0.95rem;
        line-height: 1.6;
        font-weight: 400;
    }

    .export-column-actions {
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.65rem;
        flex-wrap: wrap;
    }

    .export-column-actions .btn {
        min-width: 110px;
        border-radius: 8px !important;
        font-weight: 600;
        font-size: 0.875rem;
        padding: 0.5rem 1rem;
        box-shadow: none !important;
    }

    .export-column-actions .btn-outline-primary {
        border-color: var(--export-modal-accent) !important;
        color: var(--export-modal-accent) !important;
    }

    .export-column-actions .btn-outline-primary:hover {
        background: var(--export-modal-accent) !important;
        color: #ffffff !important;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(79, 70, 229, 0.25) !important;
    }

    body.dark-layout .export-column-actions .btn-outline-primary:hover,
    body[data-theme="dark"] .export-column-actions .btn-outline-primary:hover {
        box-shadow: 0 4px 12px rgba(139, 130, 255, 0.35) !important;
    }

    .export-column-actions .btn-outline-secondary {
        border-color: var(--export-modal-border) !important;
        color: var(--export-modal-text-muted) !important;
    }

    .export-column-actions .btn-outline-secondary:hover {
        background: var(--export-modal-bg-muted) !important;
        border-color: var(--export-modal-border) !important;
        color: var(--export-modal-text) !important;
        transform: translateY(-1px);
    }

    .export-column-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 0.75rem;
        max-height: 400px;
        overflow-y: auto;
        padding: 1rem;
        border: 1px solid var(--export-modal-border);
        border-radius: 12px;
        background: var(--export-modal-bg-soft);
    }

    .export-column-grid::-webkit-scrollbar {
        width: 8px;
    }

    .export-column-grid::-webkit-scrollbar-track {
        background: transparent;
        border-radius: 10px;
    }

    .export-column-grid::-webkit-scrollbar-thumb {
        background: var(--export-modal-border);
        border-radius: 10px;
    }

    .export-column-grid::-webkit-scrollbar-thumb:hover {
        background: var(--export-modal-text-muted);
    }

    .export-column-option {
        display: flex;
        flex-direction: row;
        align-items: center;
        gap: 0.75rem;
        padding: 1rem 1.1rem;
        border-radius: 10px;
        cursor: pointer;
        border: 1.5px solid var(--export-modal-border);
        background: var(--export-modal-bg);
        min-width: 0;
        width: 100%;
        margin: 0;
        box-shadow: var(--export-modal-card-shadow);
        position: relative;
    }

    .export-column-option:hover {
        background: var(--export-modal-bg);
        border-color: var(--export-modal-hover-border);
        box-shadow: var(--export-modal-card-hover-shadow);
        transform: translateY(-2px);
    }

    .export-column-option.is-selected {
        border-color: var(--export-modal-selected-border);
        background: var(--export-modal-selected-bg);
        box-shadow: var(--export-modal-card-selected-shadow);
    }

    .export-column-option.is-selected::before {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        border-radius: 9px;
        background: linear-gradient(135deg, transparent 0%, var(--export-modal-accent-bg) 100%);
        opacity: 0.3;
        pointer-events: none;
    }

    .export-column-option input {
        margin: 0;
        cursor: pointer;
        width: 1.15rem;
        height: 1.15rem;
        flex-shrink: 0;
        accent-color: var(--export-modal-accent);
        position: relative;
        z-index: 1;
    }

    .export-column-option .export-column-label {
        margin: 0;
        font-size: 0.9rem;
        color: var(--export-modal-text) !important;
        line-height: 1.5;
        text-align: start;
        display: block;
        word-break: break-word;
        font-weight: 500;
        position: relative;
        z-index: 1;
    }

    .export-column-option.is-selected .export-column-label {
        color: var(--export-modal-text) !important;
        font-weight: 600;
    }

    .export-column-modal-footer {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 12px;
        border-top: 1px solid var(--export-modal-border);
        padding: 24px;
        background: var(--export-modal-bg) !important;
        border-radius: 0 0 12px 12px;
    }

    .export-column-modal-footer .btn-primary {
        min-width: 170px;
        border-radius: 8px !important;
        padding: 0.75rem 1.5rem;
        font-weight: 600;
        background: var(--export-modal-accent) !important;
        border-color: var(--export-modal-accent) !important;
    }

    .export-column-modal-footer .btn-primary:hover {
        background: var(--export-modal-accent-soft) !important;
        border-color: var(--export-modal-accent-soft) !important;
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(79, 70, 229, 0.35) !important;
    }

    .export-column-modal-footer .btn-secondary {
        border-radius: 8px !important;
        background: var(--export-modal-bg) !important;
        border-color: var(--export-modal-border) !important;
        color: var(--export-modal-text-muted) !important;
        font-weight: 600;
        padding: 0.75rem 1.25rem;
    }

    .export-column-modal-footer .btn-secondary:hover {
        background: #f3f4f6 !important;
        border-color: var(--export-modal-border) !important;
        color: var(--export-modal-text) !important;
    }

    body.dark-layout .export-column-modal-footer .btn-secondary:hover,
    body[data-theme="dark"] .export-column-modal-footer .btn-secondary:hover {
        background: #374151 !important;
    }

    #export-column-loading {
        color: var(--export-modal-text-muted) !important;
        background: var(--export-modal-bg-soft);
        border: 2px dashed var(--export-modal-border);
        border-radius: 12px;
        padding: 2rem 1rem !important;
    }

    #export-column-loading .spinner-border {
        vertical-align: middle;
        color: var(--export-modal-accent);
        width: 1.5rem;
        height: 1.5rem;
        border-width: 3px;
    }

    #export-column-loading span:not(.spinner-border) {
        font-size: 0.95rem;
        font-weight: 500;
        color: var(--export-modal-text-muted) !important;
    }

    .export-column-error {
        border-radius: 12px !important;
        font-weight: 600;
        border: none !important;
        background: #fee2e2 !important;
        color: #991b1b !important;
    }

    body.dark-layout .export-column-error,
    body[data-theme="dark"] .export-column-error {
        background: rgba(239, 68, 68, 0.15) !important;
        color: #fca5a5 !important;
    }

    @media (max-width: 576px) {
        .export-column-grid {
            grid-template-columns: 1fr;
        }

        .export-column-modal-header,
        .export-column-modal-body,
        .export-column-modal-footer {
            padding-inline: 1rem;
        }

        .export-column-modal-footer {
            flex-direction: column-reverse;
        }

        .export-column-modal-footer .btn,
        .export-column-actions .btn {
            width: 100%;
        }
    }

    @media (min-width: 577px) and (max-width: 991px) {
        .export-column-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
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
        syncSelectedState();
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
        syncSelectedState();
    }

    function syncSelectedState() {
        $('.export-column-option').each(function() {
            var isChecked = $(this).find('.export-column-cb').is(':checked');
            $(this).toggleClass('is-selected', isChecked);
        });
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
    $(document).on('change', '.export-column-cb', syncSelectedState);

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
