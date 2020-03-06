<a href="{{ route('products.edit', $product) }}" class="btn btn-primary">
    <i class="fa fa-edit"></i>@routeIs('products.show', $product) {{ __("Editar") }} @endif
</a>
@if($product->invoices->count() == 0)
    <button type="button" class="btn btn-danger" data-route="{{ route('products.destroy', $product) }}" data-toggle="modal"
            data-target="#confirmDeleteModal">
        <i class="fa fa-trash"></i>@routeIs('products.show', $product)  {{ __("Eliminar") }} @endif
    </button>
@endif
