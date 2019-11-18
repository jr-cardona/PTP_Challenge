<a href="{{ route('invoices.edit', $invoice) }}" class="btn btn-primary">
    Editar
</a>
<a href="#" onclick="document.getElementById('delete-invoices').submit()" class="btn btn-danger">
    Eliminar
</a>
<form id="delete-invoices" method="POST" action="{{ route('invoices.destroy', $invoice) }}" class="d-none">
    @csrf @method('DELETE')
</form>
