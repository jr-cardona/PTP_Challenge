@extends('layouts.app')
@section('title', 'Editar Detalle')
@section('content')
    <div class="card">
        <div class="card-header">
            <h1>Editar detalle. Factura de venta No. {{ $invoice->id }}</h1>
        </div>
        <div class="card-body">
            <form action="{{ route('invoiceDetails.update', [$invoice, $product]) }}" class="form-group" method="POST">
                @method('PUT') @csrf
                <div class="row">
                    <div class="col">
                        <label>Producto</label>
                        <span class="form-control">
                            {{ $product->id }}
                        </span>
                    </div>
                    @include('invoices.details._form', [
                        'quantity' => $invoice->products->find($product->id)->pivot->quantity,
                        'unit_price' => $invoice->products->find($product->id)->pivot->unit_price
                    ])
                </div>
                <br>
                @include('invoices.details._buttons')
            </form>
        </div>
    </div>
@endsection
