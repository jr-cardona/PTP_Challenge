@extends('layouts.index')
@section('Title', 'Vendedores')
@section('Name', 'Vendedores')
@section('Create')
    <a class="btn btn-success" href="{{ route('sellers.create') }}">Crear nuevo vendedor</a>
@endsection
@section('Links')
    {{ $sellers->links() }}
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
