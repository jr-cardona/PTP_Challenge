@extends('layouts.index')
@section('Title', 'Facturas')
@section('Name', 'Facturas')
@section('Create')
    <a class="btn btn-secondary" href="{{ route('invoices.exportExcel') }}">
        <i class="fa fa-file-excel-o"></i> {{ __("Exportar a Excel") }}
    </a>
    <button type="button" class="btn btn-warning" data-route="{{ route('invoices.importExcel') }}" data-toggle="modal" data-target="#importInvoicesModal">
        <i class="fa fa-file-excel-o"></i> {{ __("Importar desde Excel") }}
    </button>
    <a class="btn btn-success" href="{{ route('invoices.create') }}">
        <i class="fa fa-plus"></i> {{ __("Crear nueva factura") }}
    </a>
@endsection
@section('Search')
    <form action="{{ route('invoices.index') }}" method="get">
        <div class="form-group row">
            <div class="col-md-3">
                <label for="issued_init">{{ __("Fecha inicial de expedición") }}</label>
                <input type="date" name="issued_init" id="issued_init" class="form-control" value="{{ $request->get('issued_init') }}">
            </div>
            <div class="col-md-3">
                <label for="issued_final">{{ __("Fecha final de expedición") }}</label>
                <input type="date" name="issued_final" id="issued_final" class="form-control" value="{{ $request->get('issued_final') }}">
            </div>
            <div class="col-md-3">
                <label for="overdued_init">{{ __("Fecha inicial de vencimiento") }}</label>
                <input type="date" name="overdued_init" id="overdued_init" class="form-control" value="{{ $request->get('overdued_init') }}">
            </div>
            <div class="col-md-3">
                <label for="overdued_final">{{ __("Fecha final de vencimiento") }}</label>
                <input type="date" name="overdued_final" id="overdued_final" class="form-control" value="{{ $request->get('overdued_final') }}">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label for="number">{{ __("Número de factura") }}</label>
                <input type="number" id="number" name="number" class="form-control" placeholder="No. de factura" value="{{ $request->get('number') }}">
            </div>
            <div class="col-md-3">
                <label for="state_id">{{ __("Estado") }}</label>
                <select id="state_id" name="state_id" class="form-control">
                    <option value="">--</option>
                    @foreach($states as $state)
                        <option value="{{ $state->id }}" {{ $request->get('state_id') == $state->id ? 'selected' : ''}}>
                            {{ $state->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label>{{ __("Cliente") }}</label>
                <v-select label="name" :filterable="false" :options="options" @search="searchClient">
                    <template slot="no-options">
                        {{ __("Ingresa el nombre del cliente...") }}
                    </template>
                    <template slot="option" slot-scope="option">
                        <div class="d-center">
                            @{{ option.name }}
                        </div>
                    </template>
                    <template slot="selected-option" slot-scope="option">
                        <div class="selected d-center">
                            @{{ option.name }}
                        </div>
                        <input type="hidden" name="client_id" id="client_id" :value='option.id'>
                    </template>
                </v-select>
            </div>
            <div class="col-md-3">
                <label>{{ __("Vendedor") }}</label>
                <v-select label="name" :filterable="false" :options="options" @search="searchSeller">
                    <template slot="no-options">
                        {{ __("Ingresa el nombre del vendedor...") }}
                    </template>
                    <template slot="option" slot-scope="option">
                        <div class="d-center">
                            @{{ option.name }}
                        </div>
                    </template>
                    <template slot="selected-option" slot-scope="option">
                        <div class="selected d-center">
                            @{{ option.name }}
                        </div>
                        <input type="hidden" name="seller_id" id="seller_id" :value='option.id'>
                    </template>
                </v-select>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label>{{ __("Producto") }}</label>
                <v-select label="name" :filterable="false" :options="options" @search="searchProduct">
                    <template slot="no-options">
                        {{ __("Ingresa el nombre del producto...") }}
                    </template>
                    <template slot="option" slot-scope="option">
                        <div class="d-center">
                            @{{ option.name }}
                        </div>
                    </template>
                    <template slot="selected-option" slot-scope="option">
                        <div class="selected d-center">
                            @{{ option.name }}
                        </div>
                        <input type="hidden" name="product_id" id="product_id" :value='option.id'>
                    </template>
                </v-select>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3 btn-group btn-group-sm">
                <button type="submit" class="btn btn-primary">
                    <i class="fa fa-search"></i> {{ __("Buscar") }}
                </button>
                <a href="{{ route('invoices.index') }}" class="btn btn-danger">
                    <i class="fa fa-undo"></i> {{ __("Limpiar") }}
                </a>
            </div>
        </div>
    </form>
@endsection
@section('Header')
    <th scope="col" nowrap>{{ __("Título") }}</th>
    <th scope="col" nowrap>{{ __("Fecha de expedición") }}</th>
    <th scope="col" nowrap>{{ __("Fecha de vencimiento") }}</th>
    <th scope="col" nowrap>{{ __("Estado") }}</th>
    <th scope="col" nowrap>{{ __("Cliente") }}</th>
    <th scope="col" nowrap>{{ __("Vendedor") }}</th>
    <th scope="col" nowrap>{{ __("Opciones") }}</th>
@endsection
@section('Body')
    @foreach($invoices as $invoice)
        <tr class="text-center">
            <td nowrap>
                <a href="{{ route('invoices.show', $invoice) }}">
                    {{ __("Factura de venta No.") }} {{ $invoice->number }}
                </a>
            </td>
            <td nowrap>{{ $invoice->issued_at }}</td>
            <td nowrap>{{ $invoice->overdued_at }}</td>
            <td nowrap>{{ $invoice->state->name }}</td>
            <td nowrap>
                <a href="{{ route('clients.show', $invoice->client) }}" target="_blank">
                    {{ $invoice->client->name }}
                </a>
            </td>
            <td nowrap>
                <a href="{{ route('sellers.show', $invoice->seller) }}" target="_blank">
                    {{ $invoice->seller->name }}
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
@push('modals')
    @include('partials.__import_invoices_modal')
@endpush
@push('scripts')
    <script src="{{ asset(mix('js/import-invoices-modal.js')) }}"></script>
@endpush
