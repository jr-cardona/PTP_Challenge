@extends('layouts.app')
@section('title', 'Crear Producto')
@section('content')
    <div class="card">
        <div class="card-header">
            <h1>Crear Producto</h1>
        </div>
        <div class="card-body">
            <form action="{{ route('products.store') }}" class="form-group" method="POST">
                @include('products._form')
            </form>
        </div>
    </div>
@endsection
