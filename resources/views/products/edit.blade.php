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
                    <button type="submit" class="btn btn-success">
                        <i class="fa fa-save"></i> {{ __("Actualizar") }}
                    </button>
                    <a href="{{ route("products.show", $product) }}" class="btn btn-secondary">
                        <i class="fa fa-arrow-left"></i> {{ __("Volver") }}
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
