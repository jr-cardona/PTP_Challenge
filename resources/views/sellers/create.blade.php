@extends('layouts.app')
@section('title', 'Crear Vendedor')
@section('content')
    <div class="card">
        <div class="card-header">
            <h1>{{ __("Crear Vendedor") }}</h1>
        </div>
        <div class="card-body">
            <form action="{{ route('sellers.store') }}" class="form-group" method="POST">
                @include('sellers._form')
                <div class="form-group">
                    <input type="submit" class="btn btn-primary" value="Guardar">
                    <a href="{{ route('sellers.index') }}" class="btn btn-danger">{{ __("Volver") }}</a>
                </div>
            </form>
        </div>
    </div>
@endsection
