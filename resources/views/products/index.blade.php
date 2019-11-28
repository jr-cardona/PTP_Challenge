@extends('layouts.index')
@section('Title', 'Productos')
@section('Name', 'Productos')
@section('Create')
    <a class="btn btn-success" href="{{ route('products.create') }}">Crear nuevo producto</a>
@endsection
@section('Links')
    {{ $products->links() }}
@endsection
@section('Header')
    <th scope="col">Código</th>
    <th scope="col">Nombre</th>
    <th scope="col">Descripción</th>
    <th scope="col" nowrap>Fecha de creación</th>
    <th scope="col" nowrap>Fecha de modificación</th>
    <th scope="col" nowrap>Opciones</th>
@endsection
@section('Body')
    @foreach($products as $product)
        <tr class="text-center">
            <td>{{ $product->id }}</td>
            <td>
                <a href="{{ route('products.show', $product) }}">
                    {{ $product->name }}
                </a>
            </td>
            <td>{{ $product->description }}</td>
            <td nowrap>{{ $product->created_at }}</td>
            <td nowrap>{{ $product->updated_at }}</td>
            <td class="btn-group btn-group-sm" nowrap>
                @include('products._buttons')
            </td>
        </tr>
    @endforeach
@endsection
