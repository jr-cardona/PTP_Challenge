@extends('layouts.show')
@section('Title', 'Ver Producto')
@section('Back')
    <div>
        <a href="{{ route('products.index') }}" class="btn btn-secondary">
            <i class="fa fa-arrow-left"></i> {{ __("Volver") }}
        </a>
    </div>
    <div>
        <a class="btn btn-success" href="{{ route('products.create') }}">
            <i class="fa fa-plus"></i> {{ __("Crear nuevo producto") }}
        </a>
    </div>
@endsection
@section('Name')
    {{ $product->name }}
@endsection
@section('Buttons')
    @include('products._buttons')
@endsection
@section('Body')
    <div class="shadow">
        <div class="card-header text-center"><h3>{{ __("Datos generales") }}</h3></div>
        <table class="table border-rounded table-sm">
            <tr>
                <td class="table-dark td-title">{{ __("Nombre:") }}</td>
                <td class="td-content">{{ $product->name }}</td>
            </tr>
            <tr>
                <td class="table-dark td-title">{{ __("Costo:") }}</td>
                <td class="td-content">${{ number_format($product->cost, 2) }}</td>

                <td class="table-dark td-title">{{ __("Precio:") }}</td>
                <td class="td-content">${{ number_format($product->price, 2) }}</td>
            </tr>
            <tr>
                <td class="table-dark td-title">{{ __("Fecha de creación:") }}</td>
                <td class="td-content">{{ $product->created_at->isoFormat('Y-MM-DD hh:mma') }}</td>

                <td class="table-dark td-title">{{ __("Fecha de modificación:") }}</td>
                <td class="td-content">{{ $product->updated_at->isoFormat('Y-MM-DD hh:mma') }}</td>
            </tr>
            <tr>
                <td class="table-dark td-title">{{ __("Descripción:") }}</td>
                <td class="td-content">{{ $product->description }}</td>
            </tr>
        </table>
    </div>
@endsection
