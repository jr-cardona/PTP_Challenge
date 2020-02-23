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
    <a class="btn btn-secondary" href="{{ route('export.products') }}">
        <i class="fa fa-file-excel"></i> {{ __("Exportar a Excel") }}
    </a>
    <button type="button" class="btn btn-warning" data-route="{{ route('import.products') }}" data-toggle="modal" data-target="#importModal">
        <i class="fa fa-file-excel"></i> {{ __("Importar desde Excel") }}
    </button>
    <a class="btn btn-success" href="{{ route('products.create') }}">
        <i class="fa fa-plus"></i> {{ __("Crear nuevo producto") }}
    </a>
@endsection
@section('Search')
    @include('products.__search_modal')
@endsection
@section('Header')
    <th class="text-center" nowrap>{{ __("Código") }}</th>
    <th class="text-center" nowrap>{{ __("Nombre") }}</th>
    <th class="text-center" nowrap>{{ __("Precio unitario") }}</th>
    <th class="text-center" nowrap>{{ __("Fecha de creación") }}</th>
    <th class="text-center" nowrap>{{ __("Fecha de modificación") }}</th>
    <th class="text-center" nowrap>{{ __("Opciones") }}</th>
@endsection
@section('Body')
    @forelse($products as $product)
        <tr class="text-center">
            <td>{{ $product->id }}</td>
            <td>
                <a href="{{ route('products.show', $product) }}">
                    {{ $product->name }}
                </a>
            </td>
            <td nowrap>$ {{ number_format($product->price, 2) }}</td>
            <td nowrap>{{ $product->created_at->isoFormat('Y-MM-DD hh:mma') }}</td>
            <td nowrap>{{ $product->updated_at->isoFormat('Y-MM-DD hh:mma') }}</td>
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
