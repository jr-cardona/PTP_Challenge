<a href="{{ route('invoices.edit', $invoice) }}" class="btn btn-primary">
    <i class="fa fa-edit"></i> Editar
</a>
<button type="button" class="btn btn-danger" data-route="{{ route('invoices.destroy', $invoice) }}" data-toggle="modal" data-target="#confirmDeleteModal">
    <i class="fa fa-trash"></i> Eliminar
</button>
