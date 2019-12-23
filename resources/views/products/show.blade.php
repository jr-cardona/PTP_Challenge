@extends('layouts.show')
@section('Title', 'Ver Producto')
@section('Back')
    <a href="{{ route('products.index') }}" class="btn btn-secondary">
        <i class="fa fa-arrow-left"></i> {{ __("Volver") }}
    </a>
@endsection
@section('Name')
    {{ $product->name }}
@endsection
@section('Buttons')
    @include('products._buttons')
@endsection
@section('Body')
    <table class="table border-rounded table-sm">
        <tr>
            <td class="table-dark td-title">{{ __("Nombre:") }}</td>
            <td class="td-content">{{ $product->name }}</td>

            <td class="table-dark td-title">{{ __("Precio unitario:") }}</td>
            <td class="td-content">{{ $product->unit_price }}</td>
        </tr>
        <tr>
            <td class="table-dark td-title">{{ __("Creado:") }}</td>
            <td class="td-content">{{ $product->created_at }}</td>

            <td class="table-dark td-title">{{ __("Modificado:") }}</td>
            <td class="td-content">{{ $product->updated_at }}</td>
        </tr>
        <tr>
            <td class="table-dark td-title">{{ __("Descripción:") }}</td>
            <td class="td-content">{{ $product->description }}</td>
        </tr>
    </table>
@endsection
