@extends('layouts.app')
@section('title', 'Editar Factura')
@section('content')
    <div class="card">
        <div class="card-header">
            <h1>{{ __("Editar Factura") }} {{ $invoice->id }}</h1>
        </div>
        <div class="card-body">
            <form action="{{ route('invoices.update', $invoice) }}" class="form-group" method="POST">
                @method('PUT')
                @include('invoices._form')
                <div class="form-group">
                    <input type="submit" class="btn btn-primary" value="Guardar">
                    <a href="{{ route('invoices.show', $invoice) }}" class="btn btn-danger">{{ __("Volver") }}</a>
                </div>
            </form>
        </div>
    </div>
@endsection
