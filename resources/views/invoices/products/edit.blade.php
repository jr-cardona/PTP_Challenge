@extends('layouts.app')
@section('title', 'Editar Detalle')
@section('content')
    <div class="card">
        <div class="card-header">
            <h1>{{ __("Editar detalle") }} {{ $invoice->fullname }}</h1>
        </div>
        <div class="card-body">
            <form action="{{ route('invoices.products.update', [$invoice, $product]) }}" class="form-group" method="POST">
                @method('PUT') @csrf
                <div class="row">
                    <div class="col">
                        <label>{{ __("Producto") }}</label>
                        <span class="form-control">
                            {{ $product->name }}
                        </span>
                    </div>
                    @include('invoices.products._form', [
                        'quantity' => $invoice->products->find($product->id)->pivot->quantity,
                        'unit_price' => $invoice->products->find($product->id)->pivot->unit_price
                    ])
                </div>
                <br>
                @include('invoices.products._buttons')
            </form>
        </div>
    </div>
@endsection
