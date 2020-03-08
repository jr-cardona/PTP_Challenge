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
    <button type="button" class="btn btn-warning" data-route="{{ route('invoices.index') }}" data-toggle="modal" data-target="#exportModal">
        <i class="fa fa-file"></i> {{ __("Exportar") }}
    </button>
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
    @forelse($invoices as $invoice)
        <tr>
            <td nowrap>
                <a href="{{ route('invoices.show', $invoice) }}">
                    {{ $invoice->fullname }}
                    @include('invoices.__symbol')
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
                {{ $invoice->owner->name }}
            </td>
            <td class="btn-group btn-group-sm" nowrap>
                @include('invoices._buttons')
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="8" class="p-3">
                <p class="alert alert-secondary text-center">
                    {{ __('No se encontraron facturas') }}
                </p>
            </td>
        </tr>
    @endforelse
@endsection
@section('Links')
    {{ $invoices->appends($request->all())->links() }}
@endsection
@push('modals')
    @include('invoices.__confirm_annulment_modal')
@endpush
@push('scripts')
    <script src="{{ asset(mix('js/annul-modal.js')) }}"></script>
@endpush
