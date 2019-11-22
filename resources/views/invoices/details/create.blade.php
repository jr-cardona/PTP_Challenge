@extends('layouts.app')
@section('title', 'Agregar Detalle')
@section('content')
    <div class="card">
        <div class="card-header">
            <h1>Agregar detalle. Factura de venta No. {{ $invoice->id }}</h1>
        </div>
        <div class="card-body">
            <form action="{{ route('invoices.storeDetail') }}" class="form-group" method="POST">
                @csrf
                <div class="row">
                    <div class="col">
                        <label for="product_id">Producto</label>
                        <select id="product_id" name="product_id" class="form-control @error('product_id') is-invalid @enderror">
                            <option value="">--</option>
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
                    <div class="col">
                        <label for="unit_price">Precio</label>
                        <input type="number" name="unit_price" id="unit_price" value="{{ old('unit_price', $invoice->unit_price) }}"
                               class="form-control @error('unit_price') is-invalid @enderror">
                        @error('unit_price')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="col">
                        <label for="quantity">Cantidad</label>
                        <input type="number" name="quantity" id="quantity" value="{{ old('quantity', $invoice->quantity) }}"
                               class="form-control @error('quantity') is-invalid @enderror">
                        @error('quantity')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <br>
                <input type="hidden" name="invoice_id" id="invoice_id" value="{{ $invoice->id }}">
                <div class="form-group">
                    <input type="submit" class="btn btn-primary" value="Guardar">
                    <a href="{{ route('invoices.show', $invoice) }}" class="btn btn-danger">Volver</a>
                </div>
            </form>
        </div>
    </div>
@endsection
