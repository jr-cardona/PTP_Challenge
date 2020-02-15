@extends('layouts.index')
@section('Title', 'Facturas')
@section('Name')
    {{ __("Facturas") }}
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#searchModal">
        <i class="fa fa-filter"></i>
    </button>
    <a href="{{ route('invoices.index') }}" class="btn btn-danger">
        <i class="fa fa-undo"></i>
    </a>
@endsection
@section('Actions')
    <a class="btn btn-secondary" href="{{ route('export.invoices') }}">
        <i class="fa fa-file-excel"></i> {{ __("Exportar a Excel") }}
    </a>
    <button type="button" class="btn btn-warning" data-route="{{ route('import.invoices') }}" data-toggle="modal" data-target="#importModal">
        <i class="fa fa-file-excel"></i> {{ __("Importar desde Excel") }}
    </button>
    <a class="btn btn-success" href="{{ route('invoices.create') }}">
        <i class="fa fa-plus"></i> {{ __("Crear nueva factura") }}
    </a>
@endsection
@section('Search')
    @include('invoices.__search_modal')
@endsection
@section('Header')
    <th class="text-center" nowrap>{{ __("Título") }}</th>
    <th class="text-center" nowrap>{{ __("Fecha expedición") }}</th>
    <th class="text-center" nowrap>{{ __("Fecha vencimiento") }}</th>
    <th class="text-center" nowrap>{{ __("Valor total") }}</th>
    <th class="text-center" nowrap>{{ __("Estado") }}</th>
    <th class="text-center" nowrap>{{ __("Cliente") }}</th>
    <th class="text-center" nowrap>{{ __("Vendedor") }}</th>
    <th></th>
@endsection
@section('Body')
    @foreach($invoices as $invoice)
        <tr>
            <td nowrap>
                <a href="{{ route('invoices.show', $invoice) }}">
                    {{ $invoice->fullname }}
                    @if($invoice->isPaid())
                        <i class="fa fa-check-circle"></i>
                    @endif
                </a>
            </td>
            <td class="text-center" nowrap>{{ $invoice->issued_at->toDateString() }}</td>
            <td class="text-center" nowrap>{{ $invoice->expires_at->toDateString() }}</td>
            <td class="text-center" nowrap>${{ number_format($invoice->total, 2) }}</td>
            @include('invoices.status_label')
            <td nowrap>
                <a href="{{ route('clients.show', $invoice->client) }}" target="_blank">
                    {{ $invoice->client->fullname }}
                </a>
            </td>
            <td nowrap>
                <a href="{{ route('sellers.show', $invoice->seller) }}" target="_blank">
                    {{ $invoice->seller->fullname }}
                </a>
            </td>
            <td class="btn-group btn-group-sm" nowrap>
                @include('invoices._buttons')
            </td>
        </tr>
    @endforeach
@endsection
@section('Links')
    {{ $invoices->appends($request->all())->links() }}
@endsection
