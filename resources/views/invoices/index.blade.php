@extends('layouts.index')
@section('Title', 'Facturas')
@section('Left-buttons')
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#searchModal">
        <i class="fa fa-filter"></i> {{ __("Filtrar") }}
    </button>
    <a class="btn btn-danger" href="{{ route('invoices.index') }}">
        <i class="fa fa-undo"></i> {{ __("Limpiar") }}
    </a>
    @include('invoices.__search_modal')
@endsection
@section('Name')
    {{ __("Facturas") }}
@endsection
@section('Right-buttons')
    @can('export', App\Entities\Invoice::class)
        <button type="button" class="btn btn-success"
                data-toggle="modal"
                data-target="#exportModal"
                data-route="{{ route('invoices.export') }}">
            <i class="fa fa-file-download"></i> {{ __("Exportar") }}
        </button>
    @endcan
@endsection
@section('Paginator')
    @include('partials.__pagination', [
        'from'  => $invoices->firstItem() ?? 0,
        'to'    => $invoices->lastItem() ?? 0,
        'total' => $invoices->total(),
    ])
@endsection
@section('Links')
    {{ $invoices->appends($request->all())->links() }}
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
                <a @can('view', $invoice->client)
                   href="{{ route('clients.show', $invoice->client) }}"
                    @endcan>
                    {{ $invoice->client->fullname }}
                </a>
            </td>
            <td nowrap>
                <a @can('view', $invoice->seller)
                   href="{{ route('users.show', $invoice->seller) }}"
                    @endcan>
                    {{ $invoice->seller->fullname }}
                </a>
            </td>
            <td class="btn-group btn-group-sm" nowrap>
                @include('invoices.__buttons')
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
@push('modals')
    @include('invoices.__confirm_annulment_modal')
@endpush
@push('scripts')
    <script src="{{ asset(mix('js/annul-modal.js')) }}"></script>
@endpush
