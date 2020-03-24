<div class="modal fade" tabindex="-1" role="dialog" id="confirmAnnulmentModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __("¿Estás seguro?") }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="annulForm" method="post" class="form-group">
                    @method('DELETE')
                    @csrf()
                    <label for="annulment_reason" class="required">
                        {{ __("Ingresa el motivo de la anulación") }}
                    </label>
                    <textarea id="annulment_reason" name="annulment_reason" minlength="10" maxlength="50"
                              required="required" class="form-control"></textarea>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fa fa-times"></i> {{ __("Cerrar") }}
                </button>
                <button type="submit" form="annulForm" class="btn btn-warning">
                    <i class="fa fa-exclamation-circle"></i> {{ __("Anular") }}
                </button>
            </div>
        </div>
    </div>
</div>
