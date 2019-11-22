@extends('layouts.app')
@section('title', 'Clientes')
@section('content')
    <div class="row">
        <div class="col">
            <h1>Clientes</h1>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <a class="btn btn-primary" href="{{ route('clients.create') }}">Crear nuevo cliente</a>
        </div>
    </div>
    <br>
    <table class="table border-rounded table-striped">
        <thead class="thead-dark">
            <tr class="text-center">
                <th scope="col">Documento</th>
                <th scope="col" nowrap>Nombre</th>
                <th scope="col">Dirección</th>
                <th scope="col">Correo electrónico</th>
                <th scope="col">Celular</th>
                <th scope="col">Opciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($clients as $client)
                <tr class="text-center">
                    <td>
                        <a href="{{ route('clients.show', $client) }}" target="_blank">
                            {{ $client->type_document }} {{ $client->sic_code }}
                        </a>
                    </td>
                    <td>{{ $client->name }}</td>
                    <td>{{ $client->address }}</td>
                    <td>{{ $client->email }}</td>
                    <td>{{ $client->cell_phone_number }}</td>
                    <td class="text-center">
                        @include('clients._buttons')
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
