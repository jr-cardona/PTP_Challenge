<div class="modal fade" tabindex="-1" role="dialog" id="importProductsModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __("Importar Productos") }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="import" action="" method="post" enctype="multipart/form-data" >
                    <input type="file" name="products" required accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
                    @csrf()
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __("Cerrar") }}</button>
                <button type="submit" form="import" class="btn btn-warning">{{ __("Importar") }}</button>
            </div>
        </div>
    </div>
</div>
