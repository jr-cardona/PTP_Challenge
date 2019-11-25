<td class="td-button">
    <a href="{{ route('clients.edit', $client) }}" class="btn btn-primary">
        Editar
    </a>
</td>
<td class="td-button">
    <form method="POST" action="{{ route('clients.destroy', $client) }}">
        @csrf @method('DELETE')
        <button type="submit" class="btn btn-danger">
            Eliminar
        </button>
    </form>
</td>

