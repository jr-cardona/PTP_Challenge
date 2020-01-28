@extends('layouts.index')
@section('Title', 'Facturas')
@section('Name', 'Facturas')
@section('Actions')
    <a class="btn btn-secondary" href="{{ route('export.invoices') }}">
        <i class="fa fa-file-excel"></i> {{ __("Exportar a Excel") }}
    </a>
    <button type="button" class="btn btn-warning" data-route="{{ route('import.invoices') }}" data-toggle="modal" data-target="#importInvoicesModal">
        <i class="fa fa-file-excel"></i> {{ __("Importar desde Excel") }}
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
                <label>{{ __("Cliente") }}</label>
                <input type="hidden" id="old_client_name" name="old_client_name" value="{{ $request->get('client') }}">
                <input type="hidden" id="old_client_id" name="old_client_id" value="{{ $request->get('client_id') }}">
                <v-select class="form-control" v-model="old_client_values" label="name" :filterable="false" :options="options" @search="searchClient">
                    <template slot="no-options">
                        {{ __("Ingresa el nombre del cliente...") }}
                    </template>
                </v-select>
                <input type="hidden" name="client" id="client" :value="(old_client_values) ? old_client_values.name : '' ">
                <input type="hidden" name="client_id" id="client_id" :value="(old_client_values) ? old_client_values.id : '' ">
            </div>
            <div class="col-md-3">
                <label>{{ __("Vendedor") }}</label>
                <input type="hidden" id="old_seller_name" name="old_seller_name" value="{{ $request->get('seller') }}">
                <input type="hidden" id="old_seller_id" name="old_seller_id" value="{{ $request->get('seller_id') }}">
                <v-select class="form-control" v-model="old_seller_values" label="name" :filterable="false" :options="options" @search="searchSeller">
                    <template slot="no-options">
                        {{ __("Ingresa el nombre del vendedor...") }}
                    </template>
                </v-select>
                <input type="hidden" name="seller" id="seller" :value="(old_seller_values) ? old_seller_values.name : '' ">
                <input type="hidden" name="seller_id" id="seller_id" :value="(old_seller_values) ? old_seller_values.id : '' ">
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
                <label>{{ __("Producto") }}</label>
                <input type="hidden" id="old_product_name" name="old_product_name" value="{{ $request->get('product') }}">
                <input type="hidden" id="old_product_id" name="old_product_id" value="{{ $request->get('product_id') }}">
                <v-select class="form-control" v-model="old_product_values" label="name" :filterable="false" :options="options" @search="searchProduct">
                    <template slot="no-options">
                        {{ __("Ingresa el nombre del producto...") }}
                    </template>
                </v-select>
                <input type="hidden" name="product" id="product" :value="(old_product_values) ? old_product_values.name : '' ">
                <input type="hidden" name="product_id" id="product_id" :value="(old_product_values) ? old_product_values.id : '' ">
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
    <th scope="col" nowrap>{{ __("Valor total") }}</th>
    <th scope="col" nowrap>{{ __("Estado") }}</th>
    <th scope="col" nowrap>{{ __("Cliente") }}</th>
    <th scope="col" nowrap>{{ __("Vendedor") }}</th>
    <th scope="col" nowrap>{{ __("Opciones") }}</th>
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
            <td class="text-center" nowrap>{{ $invoice->issued_at->isoFormat('Y-MM-DD hh:mma') }}</td>
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
@push('modals')
    @include('partials.__import_invoices_modal')
@endpush
@push('scripts')
    <script src="{{ asset(mix('js/import-invoices-modal.js')) }}"></script>
@endpush
