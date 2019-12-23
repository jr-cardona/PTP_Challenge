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
            </form>
        </div>
    </div>
@endsection
