@extends('layouts.app')
@section('title', 'Agregar Detalle')
@section('content')
    <div class="card">
        <div class="card-header">
            <h1>{{ __("Agregar detalle. Factura de venta No.") }} {{ $invoice->id }}</h1>
        </div>
        <div class="card-body">
            <form action="{{ route('invoiceDetails.store', $invoice) }}" class="form-group" method="POST">
                @csrf
                <div class="row">
                    <div class="col">
                        <label class="required">{{ __("Producto") }}</label>
                        <v-select label="name" :filterable="false" :options="options" @search="searchProduct">
                            <template slot="no-options">
                                {{ __("Ingresa el nombre del producto...") }}
                            </template>
                            <template slot="option" slot-scope="option">
                                <div class="d-center">
                                    @{{ option.name }}
                                </div>
                            </template>
                            <template slot="selected-option" slot-scope="option">
                                <div class="selected d-center">
                                    @{{ option.name }}
                                </div>
                                <input type="hidden" name="product_id" id="product_id" :value='option.id'>
                            </template>
                        </v-select>
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
