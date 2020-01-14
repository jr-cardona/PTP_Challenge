@extends('layouts.show')
@section('Title', 'Ver Vendedor')
@section('Back')
    <a href="{{ route('sellers.index') }}" class="btn btn-secondary">
        <i class="fa fa-arrow-left"></i> {{ __("Volver") }}
    </a>
@endsection
@section('Name')
    {{ $seller->name }}
@endsection
@section('Buttons')
    @include('sellers._buttons')
@endsection
@section('Body')
    <table class="table border-rounded table-sm">
        <tr>
            <td class="table-dark td-title">{{ __("Nombre completo:") }}</td>
            <td class="td-content">{{ $seller->fullname }}</td>

            <td class="table-dark td-title">{{ __("Documento:") }}</td>
            <td class="td-content">{{ $seller->type_document->name }} {{ $seller->document }}</td>
        </tr>
        <tr>
            <td class="table-dark td-title">{{ __("Creado:")}}</td>
            <td class="td-content">{{ $seller->created_at }}</td>

            <td class="table-dark td-title">{{ __("Modificado:")}}</td>
            <td class="td-content">{{ $seller->updated_at }}</td>
        </tr>
        <tr>
            <td class="table-dark td-title">{{ __("Número telefónico:")}}</td>
            <td class="td-content">{{ $seller->phone_number }}</td>

            <td class="table-dark td-title">{{ __("Celular:")}}</td>
            <td class="td-content">{{ $seller->cell_phone_number }}</td>
        </tr>
        <tr>
            <td class="table-dark td-title">{{ __("Dirección:")}}</td>
            <td class="td-content">{{ $seller->address }}</td>

            <td class="table-dark td-title">{{ __("Correo electrónico:")}}</td>
            <td class="td-content">{{ $seller->email }}</td>
        </tr>
        <tr>
            <td class="table-dark td-title">{{ __("Facturas:")}}</td>
            <td class="td-content">
                @if($seller->invoices->isEmpty())
                    {{ __("Sin facturas asociadas")}}
                @else
                    <ul>
                        @foreach($seller->invoices as $invoice)
                            <li>
                                <a href="{{ route('invoices.show', $invoice) }}" target="_blank">
                                    {{ __("Factura de venta No.")}} {{ $invoice->id }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @endisset
            </td>
        </tr>
    </table>
@endsection
