<a href="{{ route('products.edit', $product) }}" class="btn btn-primary">
    <i class="fa fa-edit"></i> {{ __("Editar") }}
</a>
<button type="button" class="btn btn-danger" data-route="{{ route('products.destroy', $product) }}" data-toggle="modal" data-target="#confirmDeleteModal">
    <i class="fa fa-trash"></i> {{ __("Eliminar") }}
</button>
