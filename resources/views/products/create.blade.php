@extends('layouts.app')
@section('title', 'Crear Producto')
@section('content')
    <div class="card">
        <div class="card-header">
            <h1>{{ __("Crear Producto") }}</h1>
        </div>
        <div class="card-body">
            <form action="{{ route('products.store') }}" class="form-group" method="POST">
                @include('products._form')
                <div class="form-group">
                    <input type="submit" class="btn btn-primary" value="Guardar">
                    <a href="{{ route('products.index') }}" class="btn btn-danger">{{ __("Volver") }}</a>
                </div>
            </form>
        </div>
    </div>
@endsection
