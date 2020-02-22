<a href="{{ route('invoices.edit', $invoice) }}" class="btn btn-primary">
    <i class="fa fa-edit"></i>@routeIs('invoices.show', $invoice) {{ __("Editar") }} @endif
</a>
<button type="button" class="btn btn-danger" data-route="{{ route('invoices.destroy', $invoice) }}"
        data-toggle="modal" data-target="#confirmDeleteModal" data-message="Se borrará toda su lista de productos">
    <i class="fa fa-trash"></i>@routeIs('invoices.show', $invoice)  {{ __("Eliminar") }} @endif
</button>
