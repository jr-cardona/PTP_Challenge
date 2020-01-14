@extends('layouts.app')
@section('title', 'Editar Producto')
@section('content')
    <div class="card">
        <div class="card-header">
            <h1>{{ __("Editar") }} {{ $product->name }}</h1>
        </div>
        <div class="card-body">
            <form action="{{ route('products.update', $product) }}" class="form-group" method="POST">
                @method('PUT')
                @include('products._form')
                <div class="form-group">
                    <input type="submit" class="btn btn-primary" value="Guardar">
                    <a href="{{ route('products.show', $product) }}" class="btn btn-danger">{{ __("Volver") }}</a>
                </div>

            </form>
        </div>
    </div>
@endsection
