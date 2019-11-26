<td class="td-button">
    <a href="{{ route('products.edit', $product) }}" class="btn btn-primary">
        Editar
    </a>
</td>
<td class="td-button">
    <form method="POST" action="{{ route('products.destroy', $product) }}">
        @csrf @method('DELETE')
        <button type="submit" class="btn btn-danger">
            Eliminar
        </button>
    </form>
</td>

