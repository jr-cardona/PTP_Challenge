@extends('layouts.app')
@section('title', 'Facturas')
@section('content')
    <div class="row">
        <div class="col">
            <h1>Facturas</h1>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <a class="btn btn-success" href="{{ route('invoices.create') }}">Crear nueva factura</a>
        </div>
    </div>
    <br>
    {{ $invoices->links() }}
    <table class="table border-rounded table-striped">
        <thead class="thead-dark">
            <tr class="text-center">
                <th scope="col" nowrap>Título</th>
                <th scope="col" nowrap>Fecha de expedición</th>
                <th scope="col" nowrap>Fecha de vencimiento</th>
                <th scope="col" nowrap>Valor total</th>
                <th scope="col" nowrap>Estado</th>
                <th scope="col" nowrap>Cliente</th>
                <th scope="col" nowrap>Opciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($invoices as $invoice)
                <tr class="text-center">
                    <td nowrap>
                        <a href="{{ route('invoices.show', $invoice) }}">
                            Factura de venta No. {{ str_pad($invoice->id, 3, "0", STR_PAD_LEFT) }}
                        </a>
                    </td>
                    <td nowrap>{{ $invoice->issued_at }}</td>
                    <td nowrap>{{ $invoice->overdued_at }}</td>
                    <td nowrap>${{ number_format($invoice->getTotalAttribute(), 2) }}</td>
                    <td nowrap>{{ $invoice->state->name }}</td>
                    <td nowrap>
                        <a href="{{ route('clients.show', $invoice->client) }}" target="_blank">
                            {{ $invoice->client->name }}
                        </a>
                    </td>
                    <td class="btn-group btn-group-sm" nowrap>
                        @include('invoices._buttons')
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
@push('modals')
    @include('partials.__confirm_delete_modal')
@endpush
@push('scripts')
    <script src="{{ asset(mix('js/delete-modal.js')) }}"></script>
@endpush
