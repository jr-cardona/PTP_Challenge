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
                    <div class="custom-file">
                        <input type="file" name="file"
                               accept=".csv,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,
                               application/vnd.ms-excel"
                               class="custom-file-input" id="validatedCustomFile" required>
                        <label class="custom-file-label" for="validatedCustomFile">
                            {{ __("Selecciona el archivo") }}
                        </label>
                        <div class="invalid-feedback">{{ __("Archivo inválido") }}</div>
                    </div>
                    <input type="hidden" id="model" name="model">
                    <input type="hidden" id="redirect" name="redirect">
                    <input type="hidden" id="import_model" name="import_model">
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
