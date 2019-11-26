<td class="td-button">
    <a href="{{ route('invoices.edit', $invoice) }}" class="btn btn-primary">
        Editar
    </a>
</td>
<td class="td-button">
    <form method="POST" action="{{ route('invoices.destroy', $invoice) }}">
        @csrf @method('DELETE')
        <button type="submit" class="btn btn-danger">
            Eliminar
        </button>
    </form>
</td>

