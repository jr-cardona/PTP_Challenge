<div class="modal fade" tabindex="-1" role="dialog" id="exportModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __("Exportar") }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <label for="select_format">{{ __("Selecciona el formato") }}</label>
                <select class="custom-select" id="select_format" name="select_format">
                    <option value="">--</option>
                    <option value="xlsx">{{ __("XLSX") }}</option>
                    <option value="csv">{{ __("CSV") }}</option>
                    <option value="tsv">{{ __("TSV") }}</option>
                </select>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fa fa-times"></i> {{ __("Cerrar") }}
                </button>
                <button type="submit" form="searchForm" id="assign-format" class="btn btn-warning">
                    <i class="fa fa-file-excel"></i> {{ __("Exportar") }}
                </button>
            </div>
        </div>
    </div>
</div>
