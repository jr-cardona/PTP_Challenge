@extends('layouts.app')
@section('title', 'Productos')
@section('content')
    <div class="row">
        <div class="col">
            <h1>Productos</h1>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <a class="btn btn-success" href="{{ route('products.create') }}">Crear nuevo producto</a>
        </div>
    </div>
    <br>
    <table class="table border-rounded table-striped">
        <thead class="thead-dark">
            <tr style="text-align: center;">
                <th scope="col">Código</th>
                <th scope="col">Nombre</th>
                <th scope="col">Descripción</th>
                <th scope="col" nowrap>Fecha de creación</th>
                <th scope="col" nowrap>Fecha de modificación</th>
                <th scope="col" nowrap colspan="2">Opciones</th>

            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
                <tr style="text-align: center;">
                    <td>{{ $product->id }}</td>
                    <td>
                        <a href="{{ route('products.show', $product) }}" target="_blank">
                            {{ $product->name }}
                        </a>
                    </td>
                    <td>{{ $product->description }}</td>
                    <td>{{ $product->created_at }}</td>
                    <td>{{ $product->updated_at }}</td>
                    @include('products._buttons')
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
