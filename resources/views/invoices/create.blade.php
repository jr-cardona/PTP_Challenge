@extends('layouts.app')
@section('title', 'Crear Factura')
@section('content')
    <div class="card">
        <div class="card-header">
            <h1>{{ __("Crear Factura") }}</h1>
        </div>
        <div class="card-body">
            <form action="{{ route('invoices.store') }}" class="form-group" method="POST">
                @include('invoices._form')
                <div class="form-group">
                    <input type="submit" class="btn btn-primary" value="Guardar">
                    <a href="{{ route('invoices.index') }}" class="btn btn-danger">{{ __("Volver") }}</a>
                </div>
            </form>
        </div>
    </div>
@endsection
