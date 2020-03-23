<div class="modal fade" tabindex="-1" role="dialog" id="importModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __("Importar") }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="import" action="{{ route('import') }}"
                      method="post" enctype="multipart/form-data">
                    @csrf()
                    <input type="file" name="file" required
                           accept=".csv,
                           application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,
                           application/vnd.ms-excel">
                    <input type="hidden" id="model" name="model">
                    <input type="hidden" id="redirect" name="redirect">
                    <input type="hidden" id="import-model" name="import-model">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fa fa-times"></i> {{ __("Cerrar") }}
                </button>
                <button type="submit" form="import" class="btn btn-warning">
                    <i class="fa fa-file-excel"></i> {{ __("Importar") }}
                </button>
            </div>
        </div>
    </div>
</div>
