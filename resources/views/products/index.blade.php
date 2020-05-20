@extends('layouts.index')
@section('Title', 'Productos')
@section('Left-buttons')
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#searchModal">
        <i class="fa fa-filter"></i> {{ __("Filtrar") }}
    </button>
    <a href="{{ route('products.index') }}" class="btn btn-danger">
        <i class="fa fa-undo"></i> {{ __("Limpiar") }}
    </a>
    @include('products.__search_modal')
@endsection
@section('Name')
    {{ __("Productos") }}
@endsection
@section('Right-buttons')
    @can('export', App\Entities\Product::class)
        <button type="button" class="btn btn-success"
                data-toggle="modal"
                data-target="#exportModal"
                data-route="{{ route('products.export') }}">
            <i class="fa fa-file-download"></i> {{ __("Exportar") }}
        </button>
    @endcan
@endsection
@section('Paginator')
    @include('partials.__pagination', [
        'from'  => $products->firstItem() ?? 0,
        'to'    => $products->lastItem() ?? 0,
        'total' => $products->total(),
    ])
@endsection
@section('Links')
    {{ $products->appends($request->all())->links() }}
@endsection
@section('Header')
    <th class="text-center" nowrap>{{ __("Código") }}</th>
    <th class="text-center" nowrap>{{ __("Nombre") }}</th>
    <th class="text-center" nowrap>{{ __("Costo") }}</th>
    <th class="text-center" nowrap>{{ __("Precio") }}</th>
    <th class="text-center" nowrap>{{ __("Fecha de creación") }}</th>
    <th class="text-center" nowrap>{{ __("Creado por") }}</th>
    <th></th>
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
                @include('products.__buttons')
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="7" class="p-3">
                <p class="alert alert-secondary text-center">
                    {{ __('No se encontraron productos') }}
                </p>
            </td>
        </tr>
    @endforelse
@endsection
