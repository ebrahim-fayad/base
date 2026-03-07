{{-- Export column selection modal - include in admin layout --}}
<div class="modal fade" id="export-column-modal" tabindex="-1" role="dialog" aria-labelledby="export-column-modal-title" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content export-column-modal-content">
            <div class="modal-header export-column-modal-header">
                <div class="export-column-modal-title-wrap">
                    <span class="export-column-modal-kicker">{{ __('admin.export_excel') }}</span>
                    <h5 class="modal-title" id="export-column-modal-title">{{ __('admin.export') }} - {{ __('admin.select_columns') }}</h5>
                </div>
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
    #export-column-modal {
        --export-modal-bg: #ffffff;
        --export-modal-bg-soft: #f8fbff;
        --export-modal-bg-muted: #eef4ff;
        --export-modal-border: #e5e7eb;
        --export-modal-border-soft: #edf2f7;
        --export-modal-text: #111827;
        --export-modal-text-muted: #6b7280;
        --export-modal-accent: #4f46e5;
        --export-modal-accent-soft: #3451b2;
        --export-modal-accent-bg: #eef4ff;
        --export-modal-selected-border: #8fb0ff;
        --export-modal-selected-bg: #f3f7ff;
        --export-modal-hover-border: #c7d7fe;
        --export-modal-shadow: 0 28px 70px rgba(15, 23, 42, 0.18);
        --export-modal-card-shadow: 0 6px 18px rgba(15, 23, 42, 0.04);
        --export-modal-card-hover-shadow: 0 12px 24px rgba(37, 99, 235, 0.08);
        --export-modal-card-selected-shadow: 0 14px 28px rgba(79, 70, 229, 0.10);
    }

    body.dark-layout #export-column-modal,
    body[data-theme="dark"] #export-column-modal {
        --export-modal-bg: #111c34;
        --export-modal-bg-soft: #15223d;
        --export-modal-bg-muted: #1b2b4b;
        --export-modal-border: rgba(148, 163, 184, 0.18);
        --export-modal-border-soft: rgba(148, 163, 184, 0.14);
        --export-modal-text: #e5eefc;
        --export-modal-text-muted: #94a3b8;
        --export-modal-accent: #8b82ff;
        --export-modal-accent-soft: #c4b5fd;
        --export-modal-accent-bg: rgba(139, 130, 255, 0.16);
        --export-modal-selected-border: rgba(139, 130, 255, 0.5);
        --export-modal-selected-bg: rgba(139, 130, 255, 0.12);
        --export-modal-hover-border: rgba(139, 130, 255, 0.4);
        --export-modal-shadow: 0 32px 72px rgba(2, 6, 23, 0.52);
        --export-modal-card-shadow: 0 8px 22px rgba(2, 6, 23, 0.22);
        --export-modal-card-hover-shadow: 0 18px 32px rgba(2, 6, 23, 0.3);
        --export-modal-card-selected-shadow: 0 18px 32px rgba(139, 130, 255, 0.12);
    }

    #export-column-modal .modal-dialog {
        max-width: 860px;
    }

    #export-column-modal .modal-content {
        background: var(--export-modal-bg) !important;
    }

    .export-column-modal-content {
        overflow: hidden;
        border: 1px solid var(--export-modal-border) !important;
        border-radius: 24px !important;
        background: var(--export-modal-bg) !important;
        box-shadow: var(--export-modal-shadow) !important;
    }

    .export-column-modal-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 1rem;
        padding: 1.4rem 1.5rem 1rem;
        border-bottom: 1px solid var(--export-modal-border-soft);
        background: linear-gradient(180deg, var(--export-modal-bg) 0%, var(--export-modal-bg-soft) 100%);
        border-radius: 24px 24px 0 0;
    }

    .export-column-modal-title-wrap {
        display: flex;
        flex-direction: column;
        gap: 0.35rem;
    }

    .export-column-modal-kicker {
        display: inline-flex;
        align-items: center;
        width: fit-content;
        padding: 0.35rem 0.75rem;
        border-radius: 999px;
        background: var(--export-modal-accent-bg);
        color: var(--export-modal-accent-soft);
        font-size: 0.75rem;
        font-weight: 700;
    }

    .export-column-modal-header .modal-title {
        font-weight: 700;
        color: var(--export-modal-text);
        margin: 0;
        font-size: 1.1rem;
    }

    .export-column-close {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 2.5rem;
        height: 2.5rem;
        margin: 0 !important;
        padding: 0 !important;
        border: 1px solid var(--export-modal-border);
        border-radius: 0.9rem;
        background: var(--export-modal-bg);
        color: var(--export-modal-text-muted);
        font-size: 1.4rem;
        line-height: 1;
        opacity: 1;
        box-shadow: none;
    }

    .export-column-close:hover {
        background: var(--export-modal-bg-soft);
        color: var(--export-modal-text);
    }

    .export-column-modal-body {
        padding: 1.25rem 1.5rem 1.4rem;
        background: var(--export-modal-bg);
    }

    .export-column-modal-description {
        color: var(--export-modal-text-muted);
        margin-bottom: 1.15rem;
        font-size: 0.96rem;
        line-height: 1.75;
        font-weight: 500;
    }

    .export-column-actions {
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.65rem;
        flex-wrap: wrap;
    }

    .export-column-actions .btn {
        min-width: 104px;
        border-radius: 999px !important;
        font-weight: 700;
        box-shadow: none !important;
    }

    .export-column-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 0.85rem;
        max-height: 360px;
        overflow-y: auto;
        padding: 0.35rem;
        border: 1px solid var(--export-modal-border-soft);
        border-radius: 1.1rem;
        background: var(--export-modal-bg-soft);
    }

    .export-column-option {
        display: flex;
        flex-direction: row;
        align-items: center;
        gap: 0.75rem;
        padding: 0.85rem 0.95rem;
        border-radius: 14px;
        cursor: pointer;
        transition: background 0.18s ease, border-color 0.18s ease, box-shadow 0.18s ease, transform 0.18s ease;
        border: 1px solid var(--export-modal-border);
        background: var(--export-modal-bg);
        min-width: 0;
        width: 100%;
        margin: 0;
        box-shadow: var(--export-modal-card-shadow);
    }

    .export-column-option:hover {
        background: var(--export-modal-bg-soft);
        border-color: var(--export-modal-hover-border);
        box-shadow: var(--export-modal-card-hover-shadow);
        transform: translateY(-1px);
    }

    .export-column-option.is-selected {
        border-color: var(--export-modal-selected-border);
        background: linear-gradient(180deg, var(--export-modal-bg) 0%, var(--export-modal-selected-bg) 100%);
        box-shadow: var(--export-modal-card-selected-shadow);
    }

    .export-column-option input {
        margin: 0;
        cursor: pointer;
        width: 1.2rem;
        height: 1.2rem;
        flex-shrink: 0;
        accent-color: var(--export-modal-accent);
    }

    .export-column-option .export-column-label {
        margin: 0;
        font-size: 0.92rem;
        color: var(--export-modal-text);
        line-height: 1.5;
        text-align: start;
        display: block;
        word-break: break-word;
        font-weight: 600;
    }

    .export-column-modal-footer {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 0.75rem;
        border-top: 1px solid var(--export-modal-border-soft);
        padding: 1rem 1.5rem 1.35rem;
        background: var(--export-modal-bg);
        border-radius: 0 0 24px 24px;
    }

    .export-column-modal-footer .btn-primary {
        min-width: 170px;
        border-radius: 999px !important;
        padding: 0.72rem 1.35rem;
    }

    .export-column-modal-footer .btn-secondary {
        border-radius: 999px !important;
        background: var(--export-modal-bg-soft) !important;
        border-color: var(--export-modal-border-soft) !important;
        color: var(--export-modal-text-muted) !important;
    }

    #export-column-loading {
        color: var(--export-modal-text-muted);
        background: var(--export-modal-bg-soft);
        border: 1px dashed var(--export-modal-hover-border);
        border-radius: 1rem;
    }

    #export-column-loading .spinner-border {
        vertical-align: middle;
        color: var(--export-modal-accent);
    }

    .export-column-error {
        border-radius: 1rem !important;
        font-weight: 600;
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
