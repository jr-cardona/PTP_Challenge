@extends('layouts.app')
@section('title', 'Editar Factura')
@section('content')
    <div class="card">
        <div class="card-header">
            <h1>{{ __("Editar") }} {{ $invoice->fullname }}</h1>
        </div>
        <div class="card-body">
            <form action="{{ route('invoices.update', $invoice) }}" class="form-group" method="POST">
                @method('PUT')
                @include('invoices.__form')
                <div class="form-group">
                    <button type="submit" class="btn btn-success">
                        <i class="fa fa-save"></i> {{ __("Actualizar") }}
                    </button>
                    <a href="{{ route("invoices.show", $invoice) }}" class="btn btn-secondary">
                        <i class="fa fa-arrow-left"></i> {{ __("Volver") }}
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
