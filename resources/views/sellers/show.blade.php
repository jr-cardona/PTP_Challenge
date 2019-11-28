@extends('layouts.show')
@section('Title', 'Ver Vendedor')
@section('Back')
    <a href="{{ route('sellers.index') }}" class="btn btn-secondary">
        <i class="fa fa-arrow-left"></i> Volver
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
            <td class="table-dark td-title">Nombre:</td>
            <td class="td-content">{{ $seller->name }}</td>

            <td class="table-dark td-title">Documento:</td>
            <td class="td-content">{{ $seller->type_document->name }} {{ $seller->document }}</td>
        </tr>
        <tr>
            <td class="table-dark td-title">Creado:</td>
            <td class="td-content">{{ $seller->created_at }}</td>

            <td class="table-dark td-title">Modificado:</td>
            <td class="td-content">{{ $seller->updated_at }}</td>
        </tr>
        <tr>
            <td class="table-dark td-title">Número telefónico:</td>
            <td class="td-content">{{ $seller->phone_number }}</td>

            <td class="table-dark td-title">Celular:</td>
            <td class="td-content">{{ $seller->cell_phone_number }}</td>
        </tr>
        <tr>
            <td class="table-dark td-title">Dirección:</td>
            <td class="td-content">{{ $seller->address }}</td>

            <td class="table-dark td-title">Correo electrónico:</td>
            <td class="td-content">{{ $seller->email }}</td>
        </tr>
        <tr>
            <td class="table-dark td-title">Facturas:</td>
            <td class="td-content">
                @if($seller->invoices->isEmpty())
                    Sin facturas asociadas
                @else
                    <ul>
                        @foreach($seller->invoices as $invoice)
                            <li>
                                <a href="{{ route('invoices.show', $invoice) }}" target="_blank">
                                    Factura de venta No. {{ $invoice->id }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @endisset
            </td>
        </tr>
    </table>
@endsection
