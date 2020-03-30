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
                    <button type="submit" class="btn btn-success">
                        <i class="fa fa-save"></i> {{ __("Guardar") }}
                    </button>
                    <a href="{{ route("products.index") }}" class="btn btn-secondary">
                        <i class="fa fa-arrow-left"></i> {{ __("Volver") }}
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
