<a href="{{ route('products.edit', $product) }}" class="btn btn-primary">
    Editar
</a>
<a href="#" onclick="document.getElementById('delete-product').submit()" class="btn btn-danger">
    Eliminar
</a>
<form id="delete-product" method="POST" action="{{ route('products.destroy', $product) }}" class="d-none">
    @csrf @method('DELETE')
</form>
