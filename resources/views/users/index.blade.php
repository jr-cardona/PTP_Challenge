@extends('layouts.index')
@section('Title', 'Usuarios')
@section('Name')
    {{ __("Usuarios") }}
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#searchModal">
        <i class="fa fa-filter"></i>
    </button>
    <a href="{{ route('users.index') }}" class="btn btn-danger">
        <i class="fa fa-undo"></i>
    </a>
@endsection
@section('Actions')
    @can('export', App\User::class)
        <button type="button" class="btn btn-warning" data-route="{{ route('users.index') }}" data-toggle="modal" data-target="#exportModal">
            <i class="fa fa-file"></i> {{ __("Exportar") }}
        </button>
    @endcan
    @can('import', App\Entities\User::class)
        <button type="button" class="btn btn-primary"
                data-toggle="modal"
                data-target="#importModal"
                data-redirect="users.index"
                data-model="App\Entities\User"
                data-import-model="App\Imports\UsersImport">
            <i class="fa fa-file-excel"></i> {{ __("Importar") }}
        </button>
    @endcan
    @can('create', App\User::class)
        <a class="btn btn-success" href="{{ route('users.create') }}">
            <i class="fa fa-plus"></i> {{ __("Crear nuevo usuario") }}
        </a>
    @endcan
@endsection
@section('Search')
    @include('users.__search_modal')
@endsection
@section('Header')
    <th class="text-center" nowrap>{{ __("Nombre completo") }}</th>
    <th class="text-center" nowrap>{{ __("Correo electrónico") }}</th>
    <th class="text-center" nowrap>{{ __("Roles") }}</th>
    <th></th>
@endsection
@section('Body')
    @forelse($users as $user)
        <tr class="text-center">
            <td>
                <a href="{{ route('users.show', $user->id) }}">
                    {{ $user->fullname }}
                </a>
            </td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->getRoleNames()->implode(', ') }}</td>
            <td class="btn-group btn-group-sm" nowrap>
                @include('users._buttons')
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="6" class="p-3">
                <p class="alert alert-secondary text-center">
                    {{ __('No se encontraron usuarios') }}
                </p>
            </td>
        </tr>
    @endforelse
@endsection
@section('Links')
    {{ $users->appends($request->all())->links() }}
@endsection
