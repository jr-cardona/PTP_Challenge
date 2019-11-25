<td style="width:10px">
    <a href="{{ route('sellers.edit', $seller) }}" class="btn btn-primary">
        Editar
    </a>
</td>
<td style="width:10px">
    <form method="POST" action="{{ route('sellers.destroy', $seller) }}">
        @csrf @method('DELETE')
        <button type="submit" class="btn btn-danger">
            Eliminar
        </button>
    </form>
</td>

