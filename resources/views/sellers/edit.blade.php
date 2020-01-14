@extends('layouts.app')
@section('title', 'Editar Vendedor')
@section('content')
    <div class="card">
        <div class="card-header">
            <h1>{{ __("Editar") }} {{ $seller->name }}</h1>
        </div>
        <div class="card-body">
            <form action="{{ route('sellers.update', $seller) }}" class="form-group" method="POST">
                @method('PUT')
                @include('sellers._form')
                <div class="form-group">
                    <input type="submit" class="btn btn-primary" value="Guardar">
                    <a href="{{ route('sellers.show', $seller) }}" class="btn btn-danger">{{ __("Volver") }}</a>
                </div>
            </form>
        </div>
    </div>
@endsection
