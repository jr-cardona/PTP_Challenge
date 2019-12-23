<a href="{{ route('sellers.edit', $seller) }}" class="btn btn-primary">
    <i class="fa fa-edit"></i> {{ __("Editar") }}
</a>
<button type="button" class="btn btn-danger" data-route="{{ route('sellers.destroy', $seller) }}" data-toggle="modal" data-target="#confirmDeleteModal">
    <i class="fa fa-trash"></i> {{ __("Eliminar") }}
</button>
