@can('edit', $user)
    <a href="{{ route('users.edit', $user) }}" class="btn btn-primary">
        <i class="fa fa-edit"></i>@routeIs('users.show', $user) {{ __("Editar") }} @endif
    </a>
@endcan
@if($user->canBeDeleted())
    @can('delete', $user)
        <button type="button" class="btn btn-danger" data-route="{{ route('users.destroy', $user) }}"
                data-toggle="modal" data-target="#confirmDeleteModal">
            <i class="fa fa-trash"></i>@routeIs('users.show', $user) {{ __("Eliminar") }} @endif
        </button>
    @endcan
@endif
