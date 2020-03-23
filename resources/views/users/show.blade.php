@extends('layouts.show')
@section('Title', 'Ver Vendedor')
@section('Back')
    <div>
        @can('viewAny', App\Entities\User::class)
            <a href="{{ route('users.index') }}" class="btn btn-secondary">
                <i class="fa fa-arrow-left"></i> {{ __("Volver") }}
            </a>
        @endcan
    </div>
    <div>
        @can('create', App\Entities\User::class)
            <a class="btn btn-success" href="{{ route('users.create') }}">
                <i class="fa fa-plus"></i> {{ __("Crear nuevo usuario") }}
            </a>
        @endcan
    </div>
@endsection
@section('Name')
    {{ $user->fullname }}
@endsection
@section('Buttons')
    @include('users._buttons')
@endsection
@section('Body')
    <div class="shadow">
        <div class="card-header text-center"><h3>{{ __("Datos generales") }}</h3></div>
        <table class="table border-rounded table-sm">
            <tr>
                <td class="table-dark td-title">{{ __("Fecha de creación:")}}</td>
                <td class="td-content">{{ $user->created_at->isoFormat('Y-MM-DD hh:mma') }}</td>

                <td class="table-dark td-title">{{ __("Fecha de modificación:")}}</td>
                <td class="td-content">{{ $user->updated_at->isoFormat('Y-MM-DD hh:mma') }}</td>
            </tr>
            <tr>
                <td class="table-dark td-title">{{ __("Creado por:")}}</td>
                <td class="td-content">{{ $user->creator->fullname }}</td>

                <td class="table-dark td-title">{{ __("Modificado por:")}}</td>
                <td class="td-content">{{ $user->updater->fullname }}</td>
            </tr>
            <tr>
                <td class="table-dark td-title">{{ __("Correo electrónico:")}}</td>
                <td class="td-content">{{ $user->email }}</td>
            </tr>
        </table>
    </div>
    <br/>
    <div class="shadow">
        <div class="card-header text-center"><h3>{{ __("Roles asociados") }}</h3></div>
        <ul class="list-group">
            @foreach($user->roles as $role)
                <li class="list-group-item">
                    <h4>{{ $role->name }}</h4>
                </li>
            @endforeach
        </ul>
    </div>
@endsection
