@extends('layouts.index')
@section('Title', 'Productos')
@section('Name', 'Productos')
@section('Create')
    <a class="btn btn-success" href="{{ route('products.create') }}">{{ __("Crear nuevo producto") }}</a>
@endsection
@section('Search')
    <form action="{{ route('products.index') }}" method="get">
        <div class="form-group row">
            <div class="col-md-3">
                <label>{{ __("Nombre") }}</label>
                <v-select label="name" :filterable="false" :options="options" @search="searchProduct">
                    <template slot="no-options">
                        {{ __("Ingresa el nombre...") }}
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
