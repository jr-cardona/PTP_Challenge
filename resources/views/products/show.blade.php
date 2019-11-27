@extends('layouts.app')
@section('title', 'Ver Producto')
@section('content')
    <a href="{{ route('products.index') }}" class="btn btn-secondary">
        <i class="fa fa-arrow-left"></i> Volver
    </a>
    <p></p>
    <div class="card card-default">
        <div class="card-header d-flex justify-content-between">
            <h3 class="card-title mb-0">{{ $product->name }}</h3>
            <div>
                <div class="btn-group btn-group-sm">
                    @include('products._buttons')
                </div>
            </div>
        </div>
        <div class="card-body">
            <table class="table border-rounded table-sm">
                <tr>
                    <td class="table-dark td-title">Nombre:</td>
                    <td class="td-content">{{ $product->name }}</td>

                    <td class="table-dark td-title">Creado:</td>
                    <td class="td-content">{{ $product->created_at }}</td>
                </tr>
                <tr>
                    <td class="table-dark td-title">Descripción:</td>
                    <td class="td-content">{{ $product->description }}</td>

                    <td class="table-dark td-title">Modificado:</td>
                    <td class="td-content">{{ $product->updated_at }}</td>
                </tr>
            </table>
        </div>
    </div>
@endsection
@push('modals')
    @include('partials.__confirm_delete_modal')
@endpush
@push('scripts')
    <script src="{{ asset('js/delete-modal.js') }}"></script>
@endpush
