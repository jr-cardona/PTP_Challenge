@extends('layouts.app')
@section('title', 'Editar Factura')
@section('content')
    <div class="card">
        <div class="card-header">
            <h1>Editar Factura {{ $invoice->id }}</h1>
        </div>
        <div class="card-body">
            <form action="{{ route('invoices.update', $invoice) }}" class="form-group" method="POST">
                @method('PUT')
                @include('invoices._form')
            </form>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="{{ asset(mix('js/search-client.js')) }}"></script>
    <script src="{{ asset(mix('js/search-seller.js')) }}"></script>
@endpush
