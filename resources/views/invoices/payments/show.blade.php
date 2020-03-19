@extends('layouts.show')
@section('title', 'Ver Transaccion')
@section('Back')
    <a href="{{ route('invoices.show', $invoice) }}" class="btn btn-secondary">
        <i class="fa fa-arrow-left"></i> {{ __("Volver a la factura") }}
    </a>
@endsection
@section('Name')
    {{ __("Transacción #") }} {{$paymentAttempt->requestID }}
@endsection
@section('Buttons')
    @if($paymentAttempt->status == 'PENDING')
        <a href="{{ $paymentAttempt->processUrl }}" class="btn btn-primary">
            <i class="fa fa-arrow-right"></i> {{ __("Continuar con el pago") }}
        </a>
    @endif
@endsection
@section('Body')
    <table class="table border-rounded table-sm">
        <tr>
            <td class="table-dark td-title">{{ __("Estado") }}</td>
            @include('invoices.payments.status_label')

            <td class="table-dark td-title">{{ __("Fecha:") }}</td>
            <td class="td-content">{{ date_format(date_create($response->status()->date()), 'Y-m-d h:ia') }}</td>
        </tr>
        <tr>
            <td class="table-dark td-title">{{ __("Mensaje:") }}</td>
            @if(isset($response->payment) && ! $paymentAttempt->isApproved())
                <td class="td-content">{{ $response->payment[0]->status()->message() }}</td>
            @else
                <td class="td-content">{{ $response->status()->message() }}</td>
            @endif
            <td class="table-dark td-title">{{ __("Monto:") }}</td>
            <td class="td-content">${{ number_format($response->request->payment()->amount()->total(), 2) }}</td>
        </tr>
        <tr>
            <td class="table-dark td-title">{{ __("Moneda:") }}</td>
            <td class="td-content">{{ $response->request->payment()->amount()->currency() }}</td>

            <td class="table-dark td-title">{{ __("Dirección IP:") }}</td>
            <td class="td-content">{{ $response->request->ipAddress() }}</td>
        </tr>
        <tr>
            @isset($response->payment)
                <td class="table-dark td-title">{{ __("Banco:") }}</td>
                <td class="td-content">{{ $response->payment()[0]->issuerName() }}</td>

                <td class="table-dark td-title">{{ __("Método de pago:") }}</td>
                <td class="td-content">{{ $response->payment()[0]->paymentMethodName() }}</td>
            @else
                <td class="table-dark td-title">{{ __("Banco:") }}</td>
                <td class="td-content">{{ __("Pendiente") }}</td>

                <td class="table-dark td-title">{{ __("Método de pago:") }}</td>
                <td class="td-content">{{ __("Pendiente") }}</td>
            @endisset
        </tr>
    </table>
    <br>
@endsection
