@can('update', $product)
    <a href="{{ route('products.edit', $product) }}" class="btn btn-primary">
        <i class="fa fa-edit"></i>@routeIs('products.show', $product) {{ __("Editar") }} @endif
    </a>
@endcan
@can('delete', $product)
    <button type="button"
            class="btn btn-danger"
            data-toggle="modal"
            data-target="#confirmDeleteModal"
            data-route="{{ route('products.destroy', $product) }}">
        <i class="fa fa-trash"></i>@routeIs('products.show', $product) {{ __("Eliminar") }} @endif
    </button>
@endcan
