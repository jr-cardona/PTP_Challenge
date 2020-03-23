@extends('layouts.index')
@section('Title', 'Productos')
@section('Name')
    {{ __("Productos") }}
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#searchModal">
        <i class="fa fa-filter"></i>
    </button>
    <a href="{{ route('products.index') }}" class="btn btn-danger">
        <i class="fa fa-undo"></i>
    </a>
@endsection
@section('Actions')
    @can('export', App\Product::class)
        <button type="button" class="btn btn-warning" data-route="{{ route('products.index') }}" data-toggle="modal" data-target="#exportModal">
            <i class="fa fa-file"></i> {{ __("Exportar") }}
        </button>
    @endcan
    @can('import', App\Entities\Product::class)
        <button type="button" class="btn btn-primary"
                data-toggle="modal"
                data-target="#importModal"
                data-redirect="products.index"
                data-model="App\Entities\Product"
                data-import-model="App\Imports\ProductsImport">
            <i class="fa fa-file-excel"></i> {{ __("Importar") }}
        </button>
    @endcan
    @can('create', App\Product::class)
        <a class="btn btn-success" href="{{ route('products.create') }}">
            <i class="fa fa-plus"></i> {{ __("Crear nuevo producto") }}
        </a>
    @endcan
@endsection
@section('Search')
    @include('products.__search_modal')
@endsection
@section('Header')
    <th class="text-center" nowrap>{{ __("Código") }}</th>
    <th class="text-center" nowrap>{{ __("Nombre") }}</th>
    <th class="text-center" nowrap>{{ __("Costo") }}</th>
    <th class="text-center" nowrap>{{ __("Precio") }}</th>
    <th class="text-center" nowrap>{{ __("Fecha de creación") }}</th>
    <th class="text-center" nowrap>{{ __("Creado por") }}</th>
    <th class="text-center" nowrap>{{ __("Opciones") }}</th>
@endsection
@section('Body')
    @forelse($products as $product)
        <tr class="text-center">
            <td>{{ $product->id }}</td>
            <td>
                <a @can('view', $product)
                   href="{{ route('products.show', $product) }}"
                    @endcan>
                    {{ $product->name }}
                </a>
            </td>
            <td nowrap>$ {{ number_format($product->cost, 2) }}</td>
            <td nowrap>$ {{ number_format($product->price, 2) }}</td>
            <td nowrap>{{ $product->created_at->isoFormat('Y-MM-DD hh:mma') }}</td>
            <td nowrap>
                <a @can('view', $product->creator)
                   href="{{ route('users.show', $product->creator) }}"
                    @endcan>
                    {{ $product->creator->fullname }}
                </a>
            </td>
            <td class="btn-group btn-group-sm" nowrap>
                @include('products._buttons')
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="6" class="p-3">
                <p class="alert alert-secondary text-center">
                    {{ __('No se encontraron productos') }}
                </p>
            </td>
        </tr>
    @endforelse
@endsection
@section('Links')
    {{ $products->appends($request->all())->links() }}
@endsection
