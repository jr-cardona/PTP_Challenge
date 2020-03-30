@extends('layouts.app')
@section('title', 'Crear Factura')
@section('content')
    <div class="card">
        <div class="card-header">
            <h1>{{ __("Crear Factura") }}</h1>
        </div>
        <div class="card-body">
            <form action="{{ route('invoices.store') }}" class="form-group" method="POST">
                @include('invoices.__form')
                <div class="form-group">
                    <button type="submit" class="btn btn-success">
                        <i class="fa fa-save"></i> {{ __("Guardar") }}
                    </button>
                    <a href="{{ route("invoices.index") }}" class="btn btn-secondary">
                        <i class="fa fa-arrow-left"></i> {{ __("Volver") }}
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
