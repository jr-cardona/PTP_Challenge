<div class="form-group">
    <button type="submit" class="btn btn-success">
        <i class="fa fa-save"></i> {{ __("Guardar") }}
    </button>
    <a href="{{ route('invoices.show', $invoice) }}" class="btn btn-secondary">
        <i class="fa fa-arrow-left"></i> {{ __("Volver") }}
    </a>
</div>
