@extends('layouts.app')
@section('title', 'Agregar Detalle')
@section('content')
    <div class="card">
        <div class="card-header">
            <h1>{{ __("Agregar producto") }} {{ $invoice->fullname }}</h1>
        </div>
        <div class="card-body">
            <form action="{{ route('invoices.products.store', $invoice) }}" class="form-group" method="POST">
                @csrf
                <div class="row">
                    <div class="col">
                        <label class="required">{{ __("Producto") }}</label>
                        <input type="hidden" id="old_product_name" name="old_product_name" value="{{ old('product') }}">
                        <input type="hidden" id="old_product_id" name="old_product_id" value="{{ old('product_id') }}">
                        <input type="hidden" id="old_product_price" name="old_product_price" value="{{ old('product_price') }}">
                        <v-select v-model="old_product_values" label="name" :filterable="false" :options="options" @search="searchProduct"
                                   class="form-control @error('product_id') is-invalid @enderror">
                            <template slot="no-options">
                                {{ __("Ingresa el nombre del producto...") }}
                            </template>
                        </v-select>
                        <input type="hidden" name="product" id="product" :value="(old_product_values) ? old_product_values.name : '' ">
                        <input type="hidden" name="product_id" id="product_id" :value="(old_product_values) ? old_product_values.id : '' ">
                        @error('product_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="col">
                        <label for="product_price">{{ __("Precio unitario") }}</label>
                        <input id="product_price" name="product_price" class="form-control" readonly="readonly"
                               :value="(old_product_values) ? old_product_values.price : '' ">
                    </div>
                    @include('invoices.products.__form', ['quantity' => ""])
                </div>
                <br>
                @include('invoices.products.__buttons')
            </form>
        </div>
    </div>
@endsection
