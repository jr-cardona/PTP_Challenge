@extends('layouts.index')
@section('Title', 'Clientes')
@section('Name', 'Clientes')
@section('Actions')
    <a class="btn btn-secondary" href="{{ route('export.clients') }}">
        <i class="fa fa-file-excel"></i> {{ __("Exportar a Excel") }}
    </a>
    <button type="button" class="btn btn-warning" data-route="{{ route('import.clients') }}" data-toggle="modal" data-target="#importModal">
        <i class="fa fa-file-excel"></i> {{ __("Importar desde Excel") }}
    </button>
    <a class="btn btn-success" href="{{ route('clients.create') }}">
        <i class="fa fa-plus"></i> {{ __("Crear nuevo cliente") }}
    </a>
@endsection
@section('Search')
    <form action="{{ route('clients.index') }}" method="get">
        <div class="form-group row">
            <div class="col-md-3">
                <label>{{ __("Nombre") }}</label>
                <input type="hidden" id="old_client_name" name="old_client_name" value="{{ $request->get('client') }}">
                <input type="hidden" id="old_client_id" name="old_client_id" value="{{ $request->get('client_id') }}">
                <v-select v-model="old_client_values" label="name" :filterable="false" :options="options" @search="searchClient"
                          class="form-control">
                    <template slot="no-options">
                        {{ __("Ingresa el nombre...") }}
                    </template>
                </v-select>
                <input type="hidden" name="client" id="client" :value="(old_client_values) ? old_client_values.name : '' ">
                <input type="hidden" name="client_id" id="client_id" :value="(old_client_values) ? old_client_values.id : '' ">
            </div>
            <div class="col-md-3">
                <label for="type_document_id">{{ __("Tipo de documento") }}</label>
                <select id="type_document_id" name="type_document_id" class="form-control">
                    <option value="">--</option>
                    @foreach($type_documents as $type_document)
                        <option value="{{ $type_document->id }}" {{ $request->get('type_document_id') == $type_document->id ? 'selected' : ''}}>
                            {{ $type_document->fullname }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label for="document">{{ __("Número de documento") }}</label>
                <input type="number" id="document" name="document" class="form-control" placeholder="No. Documento" value="{{ $request->get('document') }}">
            </div>
            <div class="col-md-3">
                <label for="email">{{ __("Correo electrónico") }}</label>
                <input type="text" id="email" name="email" class="form-control" placeholder="Correo electrónico" value="{{ $request->get('email') }}">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3 btn-group btn-group-sm">
                <button type="submit" class="btn btn-primary">
                    <i class="fa fa-search"></i> {{ __("Buscar") }}
                </button>
                <a href="{{ route('clients.index') }}" class="btn btn-danger">
                    <i class="fa fa-undo"></i> {{ __("Limpiar") }}
                </a>
            </div>
        </div>
    </form>
@endsection
@section('Header')
    <th scope="col">{{ __("Documento") }}</th>
    <th scope="col">{{ __("Nombre") }}</th>
    <th scope="col">{{ __("Apellido") }}</th>
    <th scope="col">{{ __("Correo electrónico") }}</th>
    <th scope="col">{{ __("Celular") }}</th>
    <th scope="col">{{ __("Opciones") }}</th>
@endsection
@section('Body')
    @foreach($clients as $client)
        <tr class="text-center">
            <td>
                <a href="{{ route('clients.show', $client) }}">
                    {{ $client->type_document->name }} {{ $client->document }}
                </a>
            </td>
            <td>{{ $client->name }}</td>
            <td>{{ $client->surname }}</td>
            <td>{{ $client->email }}</td>
            <td>{{ $client->cell_phone_number }}</td>
            <td class="btn-group btn-group-sm" nowrap>
                @include('clients._buttons')
            </td>
        </tr>
    @endforeach
@endsection
@section('Links')
    {{ $clients->appends($request->all())->links() }}
@endsection
@push('modals')
    @include('partials.__import_clients_modal')
@endpush
@push('scripts')
    <script src="{{ asset(mix('js/import-clients-modal.js')) }}"></script>
@endpush
