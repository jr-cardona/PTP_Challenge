<td style="width:10px">
    <a href="{{ route('clients.edit', $client) }}" class="btn btn-primary">
        Editar
    </a>
</td>
<td style="width:10px">
    <form method="POST" action="{{ route('clients.destroy', $client) }}">
        @csrf @method('DELETE')
        <button type="submit" class="btn btn-danger">
            Eliminar
        </button>
    </form>
</td>

