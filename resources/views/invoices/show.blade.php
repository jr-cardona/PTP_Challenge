@extends('layouts.show')
@section('Title', 'Ver Factura')
@section('Back')
    <div>
        <a href="{{ route('invoices.index') }}" class="btn btn-secondary">
            <i class="fa fa-arrow-left"></i> {{ __("Volver") }}
        </a>
        @if($invoice->isPending())
            <a href="{{ route('invoices.payments.create', $invoice) }}" class="btn btn-success">
                <i class="fa fa-dollar-sign"></i> {{ __("Pagar") }}
            </a>
            @empty($invoice->received_at)
                <a href="{{ route('invoices.receivedCheck', $invoice) }}" class="btn btn-primary">
                    <i class="fa fa-check"></i> {{ __("Marcar como recibida") }}
                </a>
            @endempty
        @endif
    </div>
    <div>
        <a class="btn btn-success" href="{{ route('invoices.create') }}">
            <i class="fa fa-plus"></i> {{ __("Crear nueva factura") }}
        </a>
    </div>
@endsection
@section('Name')
    {{ $invoice->fullname }}
    @if($invoice->isPaid())
        <i class="fa fa-check-circle"></i>
    @endif
@endsection
@section('Buttons')
    @include('invoices._buttons')
@endsection
@section('Body')
    <div class="shadow">
        <div class="card-header text-center"><h3>{{ __("Datos generales") }}</h3></div>
        <table class="table table-sm">
            <tr>
                <td class="table-dark td-title">{{ __("Fecha de recibo:") }}</td>
                <td class="td-content">{{ $invoice->received_at == '' ? "Sin fecha" : $invoice->received_at->isoFormat('Y-MM-DD hh:mma') }}</td>

                <td class="table-dark td-title">{{ __("Estado:") }}</td>
                @include('invoices.status_label')
            </tr>
            <tr>
                <td class="table-dark td-title">{{ __("Fecha de creación:") }}</td>
                <td class="td-content">{{ $invoice->created_at->isoFormat('Y-MM-DD hh:mma') }}</td>

                <td class="table-dark td-title" nowrap>{{ __("Fecha de modificación:") }}</td>
                <td class="td-content">{{ $invoice->updated_at->isoFormat('Y-MM-DD hh:mma') }}</td>
            </tr>
            <tr>
                <td class="table-dark td-title">{{ __("Fecha de expedición:") }}</td>
                <td class="td-content">{{ $invoice->issued_at->toDateString() }}</td>

                <td class="table-dark td-title">{{ __("Fecha de vencimiento:") }}</td>
                <td class="td-content">{{ $invoice->expires_at->toDateString() }}</td>
            </tr>
            <tr>
                <td class="table-dark td-title">{{ __("IVA:") }}</td>
                <td class="td-content">{{ Config::get('constants.vat') }}%</td>

                <td class="table-dark td-title">{{ __("Valor total:") }}</td>
                <td class="td-content">${{ number_format($invoice->total, 2) }}</td>
            </tr>
            <tr>
                <td class="table-dark td-title">{{ __("Vendedor:") }}</td>
                <td class="td-content">
                    <a href="{{ route('sellers.show', $invoice->seller) }}" target="_blank">
                        {{ $invoice->seller->fullname }}
                    </a>
                </td>

                <td class="table-dark td-title">{{ __("Cliente:") }}</td>
                <td class="td-content">
                    <a href="{{ route('clients.show', $invoice->client) }}" target="_blank">
                        {{ $invoice->client->fullname }}
                    </a>
                </td>
            </tr>
            <tr>
                <td class="table-dark td-title">{{ __("Descripción:") }}</td>
                <td class="td-content">{{ $invoice->description }}</td>
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
                @foreach($invoice->products as $product)
                    <tr>
                        <td class="text-center">
                            <a href="{{ route('products.show', $product) }}">
                                {{ $product->id }}
                            </a>
                        </td>
                        <td class="text-center">{{ $product->name }}</td>
                        <td class="text-center">{{ $product->description }}</td>
                        <td class="text-center">{{ $product->pivot->quantity }}</td>
                        <td class="text-right">{{ number_format($product->pivot->unit_price, 2) }}</td>
                        <td class="text-right">${{ number_format($product->pivot->unit_price * $product->pivot->quantity, 2) }}</td>
                        <td class="text-right">
                            @if(!$invoice->isPaid())
                                <button type="button" class="btn btn-link text-danger" data-route="{{ route('invoices.details.destroy', [$invoice, $product]) }}" data-toggle="modal" data-target="#confirmDeleteModal">
                                    <i class="fa fa-trash"></i>
                                </button>
                            @endif
                        </td>
                    </tr>
               @endforeach
                <tr>
                    <td class="text-right" colspan="5">{{ __("SUBTOTAL") }}</td>
                    <td class="text-right">${{ number_format($invoice->subtotal, 2) }}</td>
                </tr>
                <tr>
                    <td class="text-right" colspan="5">{{ __("IVA") }} ({{ Config::get('constants.vat') }})% </td>
                    <td class="text-right">${{ number_format($invoice->ivaamount, 2) }}</td>
                </tr>
                <tr>
                    <td class="text-right" colspan="5">{{ __("VALOR TOTAL") }}</td>
                    <td class="text-right">${{ number_format($invoice->total, 2) }}</td>
                </tr>
            </tbody>
        </table>
        @if(!$invoice->isPaid() && !$invoice->isExpired())
            <a href="{{ route('invoices.details.create', $invoice) }}" class="btn btn-success btn-block">
                <i class="fa fa-plus"></i> {{ __("Agregar Detalle") }}
            </a>
        @endif
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
@push('scripts')
    <script src="{{ asset(mix('js/inline-edit.js')) }}"></script>
@endpush
