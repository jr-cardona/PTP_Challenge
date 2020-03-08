@extends('layouts.show')
@section('Title', 'Ver Vendedor')
@section('Back')
    <div>
        <a href="{{ route('sellers.index') }}" class="btn btn-secondary">
            <i class="fa fa-arrow-left"></i> {{ __("Volver") }}
        </a>
    </div>
    <div>
        <a class="btn btn-success" href="{{ route('sellers.create') }}">
            <i class="fa fa-plus"></i> {{ __("Crear nuevo vendedor") }}
        </a>
    </div>
@endsection
@section('Name')
    {{ $seller->fullname }}
@endsection
@section('Buttons')
    @include('sellers._buttons')
@endsection
@section('Body')
    <div class="shadow">
        <div class="card-header text-center"><h3>{{ __("Datos generales") }}</h3></div>
        <table class="table border-rounded table-sm">
            <tr>
                <td class="table-dark td-title">{{ __("Tipo de documento:") }}</td>
                <td class="td-content">{{ $seller->type_document->fullname }}</td>

                <td class="table-dark td-title">{{ __("Número de documento:") }}</td>
                <td class="td-content">{{ $seller->document }}</td>
            </tr>
            <tr>
                <td class="table-dark td-title">{{ __("Fecha de creación:")}}</td>
                <td class="td-content">{{ $seller->created_at->isoFormat('Y-MM-DD hh:mma') }}</td>

                <td class="table-dark td-title">{{ __("Fecha de modificación:")}}</td>
                <td class="td-content">{{ $seller->updated_at->isoFormat('Y-MM-DD hh:mma') }}</td>
            </tr>
            <tr>
                <td class="table-dark td-title">{{ __("Número telefónico:")}}</td>
                <td class="td-content">{{ $seller->phone }}</td>

                <td class="table-dark td-title">{{ __("Celular:")}}</td>
                <td class="td-content">{{ $seller->cellphone }}</td>
            </tr>
            <tr>
                <td class="table-dark td-title">{{ __("Dirección:")}}</td>
                <td class="td-content">{{ $seller->address }}</td>

                <td class="table-dark td-title">{{ __("Correo electrónico:")}}</td>
                <td class="td-content">{{ $seller->email }}</td>
            </tr>
        </table>
    </div>
    <br>
    <div class="shadow">
        <div class="card-header text-center"><h3>{{ __("Facturas asociadas") }}</h3></div>
        <table class="table table-sm">
            <thead>
                <tr>
                    <th>{{ __("Título") }}</th>
                    <th>{{ __("Fecha de expedición") }}</th>
                    <th>{{ __("Fecha de vencimiento") }}</th>
                    <th>{{ __("Estado") }}</th>
                </tr>
            </thead>
            <tbody>
            @foreach($seller->invoices as $invoice)
                <tr>
                    <td>
                        <a href="{{ route('invoices.show', $invoice) }}" target="_blank">
                            {{ __("Factura de venta No.")}} {{ $invoice->id }}
                        </a>
                    </td>
                    <td>{{ $invoice->issued_at->toDateString() }}</td>
                    <td>{{ $invoice->expires_at->toDateString() }}</td>
                    @include('invoices.status_label')
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
