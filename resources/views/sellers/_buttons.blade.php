<a href="{{ route('sellers.edit', $seller) }}" class="btn btn-primary">
    <i class="fa fa-edit"></i>@routeIs('sellers.show', $seller) {{ __("Editar") }} @endif
</a>
<button type="button" class="btn btn-danger" data-route="{{ route('sellers.destroy', $seller) }}"
        data-toggle="modal" data-target="#confirmDeleteModal" data-message="Se borrarán todas sus facturas asociadas">
    <i class="fa fa-trash"></i>@routeIs('sellers.show', $seller) {{ __("Eliminar") }} @endif
</button>
