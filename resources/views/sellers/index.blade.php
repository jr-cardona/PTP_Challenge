@extends('layouts.index')
@section('Title', 'Vendedores')
@section('Name', 'Vendedores')
@section('Create')
    <a class="btn btn-success" href="{{ route('sellers.create') }}">{{ __("Crear nuevo vendedor") }}</a>
@endsection
@section('Search')
    <form action="{{ route('sellers.index') }}" method="get">
        <div class="form-group row">
            <div class="col-md-3">
                <label>{{ __("Nombre") }}</label>
                <input type="hidden" id="old_seller_name" name="old_seller_name" value="{{ $request->get('seller') }}">
                <input type="hidden" id="old_seller_id" name="old_seller_id" value="{{ $request->get('seller_id') }}">
                <v-select v-model="old_seller_values" label="name" :filterable="false" :options="options" @search="searchSeller"
                          class="form-control">
                    <template slot="no-options">
                        {{ __("Ingresa el nombre...") }}
                    </template>
                </v-select>
                <input type="hidden" name="seller" id="seller" :value="(old_seller_values) ? old_seller_values.name : '' ">
                <input type="hidden" name="seller_id" id="seller_id" :value="(old_seller_values) ? old_seller_values.id : '' ">
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
                <a href="{{ route('sellers.index') }}" class="btn btn-danger">
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
    @foreach($sellers as $seller)
        <tr class="text-center">
            <td>
                <a href="{{ route('sellers.show', $seller) }}">
                    {{ $seller->type_document->name }} {{ $seller->document }}
                </a>
            </td>
            <td>{{ $seller->name }}</td>
            <td>{{ $seller->surname }}</td>
            <td>{{ $seller->email }}</td>
            <td>{{ $seller->cell_phone_number }}</td>
            <td class="btn-group btn-group-sm" nowrap>
                @include('sellers._buttons')
            </td>
        </tr>
    @endforeach
@endsection
@section('Links')
    {{ $sellers->appends($request->all())->links() }}
@endsection
