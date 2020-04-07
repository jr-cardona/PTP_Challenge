@extends('layouts.show')
@section('Title', 'Ver Producto')
@section('Back')
    @can('viewAny', App\Entities\Product::class)
        <a href="{{ route('products.index') }}" class="btn btn-secondary">
            <i class="fa fa-arrow-left"></i> {{ __("Volver") }}
        </a>
    @endcan
@endsection
@section('Name')
    {{ $product->name }}
@endsection
@section('Buttons')
    @include('products.__buttons')
@endsection
@section('Body')
    <div class="shadow">
        <div class="card-header text-center"><h3>{{ __("Datos generales") }}</h3></div>
        <table class="table border-rounded table-sm">
            <tr>
                <td class="table-dark td-title">{{ __("Fecha de creación:") }}</td>
                <td class="td-content">{{ $product->created_at->isoFormat('Y-MM-DD hh:mma') }}</td>

                <td class="table-dark td-title">{{ __("Fecha de modificación:") }}</td>
                <td class="td-content">{{ $product->updated_at->isoFormat('Y-MM-DD hh:mma') }}</td>
            </tr>
            <tr>
                <td class="table-dark td-title">{{ __("Creado por:") }}</td>
                <td class="td-content">
                    <a @can('view', $product->creator)
                       href="{{ route('users.show', $product->creator) }}"
                        @endcan>
                        {{ $product->creator->fullname }}
                    </a>
                </td>

                <td class="table-dark td-title">{{ __("Modificado por:") }}</td>
                <td class="td-content">
                    <a @can('view', $product->updater)
                       href="{{ route('users.show', $product->updater) }}"
                        @endcan>
                        {{ $product->updater->fullname }}
                    </a>
                </td>
            </tr>
            <tr>
                <td class="table-dark td-title">{{ __("Costo:") }}</td>
                <td class="td-content">${{ number_format($product->cost, 2) }}</td>

                <td class="table-dark td-title">{{ __("Precio:") }}</td>
                <td class="td-content">${{ number_format($product->price, 2) }}</td>
            </tr>
            <tr>
                <td class="table-dark td-title">{{ __("Descripción:") }}</td>
                <td class="td-content">{{ $product->description }}</td>
            </tr>
        </table>
    </div>
@endsection
