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
                        <label for="product_id">Producto</label>
                        <select id="product_id" name="product_id" class="form-control @error('product_id') is-invalid @enderror">
                            <option value="">Selecciona un producto</option>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}" {{ old('product_id') == "$product->id" ? 'selected' : '' }}>{{ $product->name }}</option>
                            @endforeach
                        </select>
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
