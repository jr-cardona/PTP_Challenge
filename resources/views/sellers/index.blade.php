@extends('layouts.index')
@section('Title', 'Vendedores')
@section('Name', 'Vendedores')
@section('Create')
    <a class="btn btn-success" href="{{ route('sellers.create') }}">Crear nuevo vendedor</a>
@endsection
@section('Search')
    <form action="{{ route('sellers.index') }}" method="get">
        <div class="form-group row">
            <div class="col-md-3">
                <input type="hidden" name="seller_id" id="seller_id" value="{{ $request->get('seller_id') }}">
                <input type="text" name="seller" id="seller" class="form-control" placeholder="Nombre" value="{{ $request->get('seller') }}" autocomplete="off">
                <div id="sellerList" class="position-absolute" style="z-index: 999">
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
                <a href="{{ route('sellers.index') }}" class="btn btn-danger">
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
    <th scope="col" colspan="2">Opciones</th>
@endsection
@section('Body')
    @foreach($sellers as $seller)
        <tr class="text-center">
            <td>
                <a href="{{ route('sellers.show', $seller) }}">
                    {{ $seller->type_document->name }} {{ $seller->document }}
                </a>
            </td>
            <td>{{ $seller->name }}</td>
            <td>{{ $seller->address }}</td>
            <td>{{ $seller->email }}</td>
            <td>{{ $seller->cell_phone_number }}</td>
            <td class="btn-group btn-group-sm" nowrap>
                @include('sellers._buttons')
            </td>
        </tr>
    @endforeach
@endsection
@section('Links')
    {{ $sellers->appends($request->all())->links() }}
@endsection
