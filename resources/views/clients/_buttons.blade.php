@can('edit', $client)
    <a href="{{ route('clients.edit', $client) }}" class="btn btn-primary">
        <i class="fa fa-edit"></i>@routeIs('clients.show', $client) {{ __("Editar") }} @endif
    </a>
@endcan
@if($client->invoices->count() == 0)
    @can('delete', $client)
        <button type="button" class="btn btn-danger" data-route="{{ route('clients.destroy', $client) }}"
                data-toggle="modal" data-target="#confirmDeleteModal">
            <i class="fa fa-trash"></i>@routeIs('clients.show', $client) {{ __("Eliminar") }} @endif
        </button>
    @endcan
@endif
