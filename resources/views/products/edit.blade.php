@extends('layouts.app')
@section('title', 'Editar Producto')
@section('content')
    <div class="card">
        <div class="card-header">
            <h1>Editar {{ $product->name }}</h1>
        </div>
        <div class="card-body">
            <form action="{{ route('products.update', $product) }}" class="form-group" method="POST">
                @method('PUT')
                @include('products._form')
            </form>
        </div>
    </div>
@endsection
