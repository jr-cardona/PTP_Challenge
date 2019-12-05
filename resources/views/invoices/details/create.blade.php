@extends('layouts.app')
@section('title', 'Agregar Detalle')
@section('content')
    <div class="card">
        <div class="card-header">
            <h1>Agregar detalle. Factura de venta No. {{ $invoice->id }}</h1>
        </div>
        <div class="card-body">
            <form action="{{ route('invoiceDetails.store', $invoice) }}" class="form-group" method="POST">
                @csrf
                <div class="row">
                    <div class="col">
                        <label for="product">Producto</label>
                        <input type="hidden" name="product_id" id="product_id" value="{{ old('product_id') }}">
                        <input type="text" name="product" id="product" value="{{ old('product') }}" autocomplete="off"
                               class="form-control @error('product_id') is-invalid @enderror" placeholder="Nombre del producto">
                        <div id="productList" class="position-absolute" style="z-index: 999">
                        </div>
                        @error('product_id')
                        <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    @include('invoices.details._form', ['quantity' => "", 'unit_price' => ""])
                </div>
                <br>
                @include('invoices.details._buttons')
            </form>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="{{ asset(mix('js/search-product.js')) }}"></script>
@endpush
