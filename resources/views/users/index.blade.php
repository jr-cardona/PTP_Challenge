@extends('layouts.index')
@section('Title', 'Usuarios')
@section('Left-buttons')
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#searchModal">
        <i class="fa fa-filter"></i> {{ __("Filtrar") }}
    </button>
    <a href="{{ route('users.index') }}" class="btn btn-danger">
        <i class="fa fa-undo"></i> {{ __("Limpiar") }}
    </a>
    @include('users.__search_modal')
@endsection
@section('Name')
    {{ __("Usuarios") }}
@endsection
@section('Right-buttons')
    @can('export', App\Entities\User::class)
        <button type="button" class="btn btn-success"
                data-toggle="modal"
                data-target="#exportModal"
                data-route="{{ route('users.export') }}">
            <i class="fa fa-file-download"></i> {{ __("Exportar") }}
        </button>
    @endcan
@endsection
@section('Paginator')
    @include('partials.__pagination', [
        'from'  => $users->firstItem() ?? 0,
        'to'    => $users->lastItem() ?? 0,
        'total' => $users->total(),
    ])
@endsection
@section('Links')
    {{ $users->appends($request->all())->links() }}
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
                @include('users.__buttons')
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
