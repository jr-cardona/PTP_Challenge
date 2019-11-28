@extends('layouts.index')
@section('Title', 'Clientes')
@section('Name', 'Clientes')
@section('Create')
    <a class="btn btn-success" href="{{ route('clients.create') }}">Crear nuevo cliente</a>
@endsection
@section('Links')
    {{ $clients->links() }}
@endsection
@section('Header')
    <th scope="col">Documento</th>
    <th scope="col" nowrap>Nombre</th>
    <th scope="col">Dirección</th>
    <th scope="col">Correo electrónico</th>
    <th scope="col">Celular</th>
    <th scope="col">Opciones</th>
@endsection
@section('Body')
    @foreach($clients as $client)
        <tr class="text-center">
            <td>
                <a href="{{ route('clients.show', $client) }}">
                    {{ $client->type_document->name }} {{ $client->document }}
                </a>
            </td>
            <td>{{ $client->name }}</td>
            <td>{{ $client->address }}</td>
            <td>{{ $client->email }}</td>
            <td>{{ $client->cell_phone_number }}</td>
            <td class="btn-group btn-group-sm" nowrap>
                @include('clients._buttons')
            </td>
        </tr>
    @endforeach
@endsection
