@extends('layouts.app')
@section('title')
    {{ __("Clientes deudores") }}
@endsection
<div></div>
@section('content')
    @if(count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @include('reports.clients.__search_modal')
    <div class="card-header justify-content-between d-flex">
        <div class="col-md-3">
            <a href="{{ route('reports.index') }}" class="btn btn-secondary">
                <i class="fa fa-arrow-left"></i> {{ __("Volver") }}
            </a>
        </div>
        <h2 class="col-md-6">{{ __("Reporte de clientes deudores") }}</h2>
        <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#exportModal">
            <i class="fa fa-file"></i> {{ __("Exportar") }}
        </button>
    </div>
    <table class="table border-rounded table-striped table-hover">
        <thead class="custom-header">
        <tr>
            <th class="text-center">{{ __("Nombre completo") }}</th>
            <th class="text-center">{{ __("Celular") }}</th>
            <th class="text-center">{{ __("Teléfono fijo") }}</th>
            <th class="text-center">{{ __("Dirección") }}</th>
            <th class="text-center">{{ __("Deuda total") }}</th>
        </tr>
        </thead>
        <tbody>
        @forelse($clients as $client)
            <tr>
                <td class="text-center">
                    <a href="{{ route('clients.show', $client->id) }}">
                        {{ $client->fullname }}
                    </a>
                </td>
                <td class="text-center">{{ $client->cellphone }}</td>
                <td class="text-center">{{ $client->phone }}</td>
                <td class="text-center">{{ $client->address }}</td>
                <td class="text-right">${{ number_format($client->total_due * $vat, 2) }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="p-3">
                    <p class="alert alert-secondary text-center">
                        {{ __('No se encontraron clientes deudores') }}
                    </p>
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>
@endsection
@push('modals')
    @include('partials.__export_modal')
@endpush
@push('scripts')
    <script src="{{ asset(mix('js/export-modal.js')) }}"></script>
    <script src="{{ asset(mix('js/assign-format.js')) }}"></script>
@endpush
