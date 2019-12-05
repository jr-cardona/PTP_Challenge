@extends('layouts.index')
@section('Title', 'Clientes')
@section('Name', 'Clientes')
@section('Create')
    <a class="btn btn-success" href="{{ route('clients.create') }}">Crear nuevo cliente</a>
@endsection
@section('Search')
    <form action="{{ route('clients.index') }}" method="get">
        <div class="form-group row">
            <div class="col-md-3">
                <input type="hidden" name="client_id" id="client_id" value="{{ $request->get('client_id') }}">
                <input type="text" name="client" id="client" class="form-control" placeholder="Nombre" value="{{ $request->get('client') }}" autocomplete="off">
                <div id="clientList" class="position-absolute" style="z-index: 999">
                </div>
            </div>
            <div class="col-md-3">
                <select id="type_document_id" name="type_document_id" class="form-control">
                    <option value="">Tipo de documento</option>
                    @foreach($type_documents as $type_document)
                        <option value="{{ $type_document->id }}" {{ $request->get('type_document_id') == $type_document->id ? 'selected' : ''}}>
                            {{ $type_document->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <input type="number" id="document" name="document" class="form-control" placeholder="Documento" value="{{ $request->get('document') }}">
            </div>
            <div class="col-md-3">
                <input type="text" id="email" name="email" class="form-control" placeholder="Correo electrónico" value="{{ $request->get('email') }}">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3 btn-group btn-group-sm">
                <button type="submit" class="btn btn-primary">
                    <i class="fa fa-search"></i> Buscar
                </button>
                <a href="{{ route('clients.index') }}" class="btn btn-danger">
                    <i class="fa fa-undo"></i> Limpiar
                </a>
            </div>
        </div>
    </form>
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
@section('Links')
    {{ $clients->appends($request->all())->links() }}
@endsection
