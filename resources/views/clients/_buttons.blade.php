<a href="{{ route('clients.edit', $client) }}" class="btn btn-primary">
    Editar
</a>
<a href="#" onclick="document.getElementById('delete-client').submit()" class="btn btn-danger">
    Eliminar
</a>
<form id="delete-client" method="POST" action="{{ route('clients.destroy', $client) }}" class="d-none">
    @csrf @method('DELETE')
</form>
