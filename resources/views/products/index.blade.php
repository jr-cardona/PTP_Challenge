@extends('layouts.index')
@section('Title', 'Productos')
@section('Name', 'Productos')
@section('Create')
    <a class="btn btn-success" href="{{ route('products.create') }}">
        <i class="fa fa-plus"></i> {{ __("Crear nuevo producto") }}
    </a>
@endsection
@section('Search')
    <form action="{{ route('products.index') }}" method="get">
        <div class="form-group row">
            <div class="col-md-3">
                <label>{{ __("Nombre") }}</label>
                <input type="hidden" id="old_product_name" name="old_product_name" value="{{ $request->get('product') }}">
                <input type="hidden" id="old_product_id" name="old_product_id" value="{{ $request->get('product_id') }}">
                <v-select v-model="old_product_values" label="name" :filterable="false" :options="options" @search="searchProduct"
                          class="form-control">
                    <template slot="no-options">
                        {{ __("Ingresa el nombre...") }}
                    </template>
                </v-select>
                <input type="hidden" name="product" id="product" :value="(old_product_values) ? old_product_values.name : '' ">
                <input type="hidden" name="product_id" id="product_id" :value="(old_product_values) ? old_product_values.id : '' ">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3 btn-group btn-group-sm">
                <button type="submit" class="btn btn-primary">
                    <i class="fa fa-search"></i> {{ __("Buscar") }}
                </button>
                <a href="{{ route('products.index') }}" class="btn btn-danger">
                    <i class="fa fa-undo"></i> {{ __("Limpiar") }}
                </a>
            </div>
        </div>
    </form>
@endsection
@section('Header')
    <th scope="col">{{ __("Código") }}</th>
    <th scope="col">{{ __("Nombre") }}</th>
    <th scope="col">{{ __("Precio unitario") }}</th>
    <th scope="col" nowrap>{{ __("Fecha de creación") }}</th>
    <th scope="col" nowrap>{{ __("Fecha de modificación") }}</th>
    <th scope="col" nowrap>{{ __("Opciones") }}</th>
@endsection
@section('Body')
    @foreach($products as $product)
        <tr class="text-center">
            <td>{{ $product->id }}</td>
            <td>
                <a href="{{ route('products.show', $product) }}">
                    {{ $product->name }}
                </a>
            </td>
            <td nowrap>$ {{ number_format($product->unit_price, 2) }}</td>
            <td nowrap>{{ $product->created_at }}</td>
            <td nowrap>{{ $product->updated_at }}</td>
            <td class="btn-group btn-group-sm" nowrap>
                @include('products._buttons')
            </td>
        </tr>
    @endforeach
@endsection
@section('Links')
    {{ $products->appends($request->all())->links() }}
@endsection
