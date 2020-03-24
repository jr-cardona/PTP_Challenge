@extends('layouts.show')
@section('Title', 'Ver Factura')
@section('Back')
    <div>
        @can('viewAny', App\Entities\Invoice::class)
            <a href="{{ route('invoices.index') }}" class="btn btn-secondary">
                <i class="fa fa-arrow-left"></i> {{ __("Volver") }}
            </a>
        @endcan
        @can('pay', $invoice)
            <a href="{{ route('invoices.payments.create', $invoice) }}" class="btn btn-success">
                <i class="fa fa-dollar-sign"></i> {{ __("Pagar") }}
            </a>
        @endcan
        @can('receive', $invoice)
            <a href="{{ route('invoices.receivedCheck', $invoice) }}" class="btn btn-primary">
                <i class="fa fa-check"></i> {{ __("Marcar como recibida") }}
            </a>
        @endcan
    </div>
    <div>
        @can('create', App\Entities\Invoice::class)
            <a class="btn btn-success" href="{{ route('invoices.create') }}">
                <i class="fa fa-plus"></i> {{ __("Crear nueva factura") }}
            </a>
        @endcan
    </div>
@endsection
@section('Name')
    {{ $invoice->fullname }}
    @include('invoices.__symbol')
@endsection
@section('Buttons')
    @include('invoices.__buttons')
@endsection
@section('Body')
    <div class="shadow">
        <div class="card-header text-center"><h3>{{ __("Datos generales") }}</h3></div>
        <table class="table table-sm">
            <tr>
                <td class="table-dark td-title custom-header">{{ __("Fecha de recibo:") }}</td>
                <td class="td-content">{{ $invoice->received_at == '' ? "Sin fecha" : $invoice->received_at->isoFormat('Y-MM-DD hh:mma') }}</td>

                <td class="table-dark td-title custom-header">{{ __("Estado:") }}</td>
                @include('invoices.status_label')
            </tr>
            <tr>
                <td class="table-dark td-title custom-header">{{ __("Fecha de expedición:") }}</td>
                <td class="td-content">{{ $invoice->issued_at->toDateString() }}</td>

                <td class="table-dark td-title custom-header">{{ __("Fecha de vencimiento:") }}</td>
                <td class="td-content">{{ $invoice->expires_at->toDateString() }}</td>
            </tr>
            <tr>
                <td class="table-dark td-title custom-header">{{ __("Fecha de creación:") }}</td>
                <td class="td-content">{{ $invoice->created_at->isoFormat('Y-MM-DD hh:mma') }}</td>

                <td class="table-dark td-title custom-header" nowrap>{{ __("Fecha de modificación:") }}</td>
                <td class="td-content">{{ $invoice->updated_at->isoFormat('Y-MM-DD hh:mma') }}</td>
            </tr>
            <tr>
                <td class="table-dark td-title custom-header">{{ __("Vendedor:") }}</td>
                <td class="td-content">
                    <a @can('view', $invoice->seller)
                       href="{{ route('users.show', $invoice->seller) }}" target="_blank"
                        @endcan>
                        {{ $invoice->seller->fullname }}
                    </a>
                </td>

                <td class="table-dark td-title custom-header">{{ __("Modificado por:") }}</td>
                <td class="td-content">
                    <a @can('view', $invoice->updater)
                       href="{{ route('users.show', $invoice->updater) }}" target="_blank"
                        @endcan>
                        {{ $invoice->updater->fullname }}
                    </a>
                </td>
            </tr>
            <tr>
                <td class="table-dark td-title custom-header">{{ __("Cliente:") }}</td>
                <td class="td-content">
                    <a @can('view', $invoice->client)
                       href="{{ route('clients.show', $invoice->client) }}" target="_blank"
                        @endcan>
                        {{ $invoice->client->fullname }}
                    </a>
                </td>

                <td class="table-dark td-title custom-header">{{ __("IVA:") }}</td>
                <td class="td-content">{{ Config::get('constants.vat') }}%</td>

            </tr>
            <tr>
                <td class="table-dark td-title custom-header">{{ __("Descripción:") }}</td>
                <td class="td-content">{{ $invoice->description }}</td>

                @if(! empty($invoice->annulment_reason))
                    <td class="table-dark td-title custom-header">{{ __("Motivo de anulación:") }}</td>
                    <td class="td-content">{{ $invoice->annulment_reason }}</td>
                @endif
            </tr>
        </table>
    </div>
    <br>
    <div class="shadow">
        <div class="card-header text-center"><h3>{{ __("Lista de productos") }}</h3></div>
        <table class="table table-sm">
            <thead>
                <tr>
                    <th class="text-center" nowrap>{{ __("CÓDIGO") }}</th>
                    <th class="text-center" nowrap>{{ __("NOMBRE") }}</th>
                    <th class="text-center" nowrap>{{ __("DESCRIPCIÓN") }}</th>
                    <th class="text-center" nowrap>{{ __("CANTIDAD") }}</th>
                    <th class="text-right" nowrap>{{ __("PRECIO UNITARIO") }}</th>
                    <th class="text-right" nowrap>{{ __("PRECIO TOTAL") }}</th>
                    <th class="text-center"></th>
                </tr>
            </thead>
            <tbody>
                @forelse($invoice->products as $product)
                    <tr>
                        <td class="text-center">
                            <a @can('view', $product)
                               href="{{ route('products.show', $product) }}"
                                @endcan>
                                {{ $product->id }}
                            </a>
                        </td>
                        <td class="text-center">{{ $product->name }}</td>
                        <td class="text-center">{{ $product->description }}</td>
                        <td class="text-center">{{ $product->pivot->quantity }}</td>
                        <td class="text-right">{{ number_format($product->pivot->unit_price, 2) }}</td>
                        <td class="text-right">${{ number_format($product->pivot->unit_price * $product->pivot->quantity, 2) }}</td>
                        <td class="text-right btn-group btn-group-sm">
                            @can('update', $invoice)
                                <a href="{{ route('invoices.products.edit', [$invoice, $product]) }}" class="btn text-primary">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <button type="button" class="btn text-danger" data-route="{{ route('invoices.products.destroy', [$invoice, $product]) }}" data-toggle="modal" data-target="#confirmDeleteModal">
                                    <i class="fa fa-trash"></i>
                                </button>
                            @endcan
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="p-3">
                            <p class="alert alert-secondary text-center">
                                {{ __('No se encontraron productos asociados') }}
                            </p>
                        </td>
                    </tr>
                @endforelse
                @isset($invoice->products[0])
                    <tr>
                        <td colspan="4"></td>
                        <td class="text-right custom-header">
                            {{ __("SUBTOTAL") }}
                        </td>
                        <td class="text-right">${{ number_format($invoice->subtotal, 2) }}</td>
                    </tr>
                    <tr>
                        <td colspan="4"></td>
                        <td class="text-right custom-header">
                            {{ __("IVA") }} ({{ Config::get('constants.vat') }})%
                        </td>
                        <td class="text-right">${{ number_format($invoice->ivaamount, 2) }}</td>
                    </tr>
                    <tr>
                        <td colspan="4"></td>
                        <td class="text-right custom-header">
                            {{ __("VALOR TOTAL") }}
                        </td>
                        <td class="text-right">${{ number_format($invoice->total, 2) }}</td>
                    </tr>
                @endisset
            </tbody>
        </table>
        @can('update', $invoice)
            <a href="{{ route('invoices.products.create', $invoice) }}" class="btn btn-success btn-block">
                <i class="fa fa-plus"></i> {{ __("Agregar Producto") }}
            </a>
        @endcan
    </div>
    <br>
    <div class="shadow">
        <div class="card-header text-center"><h3>{{ __("Histórico de Transacciones") }}</h3></div>
        <table class="table table-sm">
            <thead>
                <tr class="text-center">
                    <th class="text-center">{{ __("Código de transacción") }}</th>
                    <th class="text-center">{{ __("Fecha") }}</th>
                    <th class="text-center">{{ __("Estado") }}</th>
                    <th class="text-center">{{ __("Monto") }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($invoice->paymentAttempts as $paymentAttempt)
                    <tr class="text-center">
                        <td>
                            <a href="{{ route("invoices.payments.show", [$invoice, $paymentAttempt]) }}">
                                {{ $paymentAttempt->requestID }}
                            </a>
                        </td>
                        <td>{{ $paymentAttempt->created_at->isoFormat('Y-MM-DD hh:mma') }}</td>
                        @include('invoices.payments.status_label')
                        <td class="text-right">${{ number_format($paymentAttempt->amount, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
@can('delete', $invoice)
    @push('modals')
        @include('invoices.__confirm_annulment_modal')
    @endpush
    @push('scripts')
        <script src="{{ asset(mix('js/annul-modal.js')) }}"></script>
    @endpush
@endcan
