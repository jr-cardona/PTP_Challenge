@extends('layouts.app')
@section('title')
    {{ __("Utilidades") }}
@endsection
<div></div>
@section('content')
    @include('reports.invoices.__search_modal')
    <div class="card-header justify-content-between d-flex">
        <div class="col-md-3">
            <a href="{{ route('reports.general') }}" class="btn btn-secondary">
                <i class="fa fa-arrow-left"></i> {{ __("Volver") }}
            </a>
        </div>
        <h2 class="col-md-6">{{ __("Reporte de utilidades") }}</h2>
        <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#exportModal">
            <i class="fa fa-file"></i> {{ __("Exportar") }}
        </button>
    </div>
    <table class="table border-rounded table-striped table-hover">
        <thead class="custom-header">
        <tr>
            <th class="text-center">{{ __("Factura") }}</th>
            <th class="text-center">{{ __("Cliente") }}</th>
            <th class="text-center">{{ __("Fecha de pago") }}</th>
            <th class="text-center">{{ __("Ingresos") }}</th>
            <th class="text-center">{{ __("Egresos") }}</th>
            <th class="text-center">{{ __("Utilidad") }}</th>
        </tr>
        </thead>
        <tbody>
        @forelse($invoices as $invoice)
            <tr>
                <td class="text-center">
                    <a href="{{ route('invoices.show', $invoice->id) }}">
                        {{ $invoice->id }}
                    </a>
                </td>
                <td class="text-center">
                    <a href="{{ route('clients.show', $invoice->client_id) }}">
                        {{ $invoice->client_fullname }}
                    </a>
                </td>
                <td class="text-center">{{ $invoice->paid_at }}</td>
                <td class="text-right">${{ number_format($invoice->income * $vat, 2) }}</td>
                <td class="text-right">${{ number_format($invoice->expenses * $vat, 2) }}</td>
                <td class="text-right">${{ number_format($invoice->utility * $vat, 2) }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="p-3">
                    <p class="alert alert-secondary text-center">
                        {{ __('No se encontraron facturas pagadas') }}
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
