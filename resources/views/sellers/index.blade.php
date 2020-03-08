@extends('layouts.index')
@section('Title', 'Vendedores')
@section('Name')
    {{ __("Vendedores") }}
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#searchModal">
        <i class="fa fa-filter"></i>
    </button>
    <a href="{{ route('sellers.index') }}" class="btn btn-danger">
        <i class="fa fa-undo"></i>
    </a>
@endsection
@section('Actions')
    <button type="button" class="btn btn-warning" data-route="{{ route('sellers.index') }}" data-toggle="modal" data-target="#exportModal">
        <i class="fa fa-file"></i> {{ __("Exportar") }}
    </button>
    <button type="button" class="btn btn-warning" data-route="{{ route('import.sellers') }}" data-toggle="modal" data-target="#importModal">
        <i class="fa fa-file-excel"></i> {{ __("Importar desde Excel") }}
    </button>
    <a class="btn btn-success" href="{{ route('sellers.create') }}">
        <i class="fa fa-plus"></i> {{ __("Crear nuevo vendedor") }}
    </a>
@endsection
@section('Search')
    @include('sellers.__search_modal')
@endsection
@section('Header')
    <th class="text-center" nowrap>{{ __("Documento") }}</th>
    <th class="text-center" nowrap>{{ __("Nombre completo") }}</th>
    <th class="text-center" nowrap>{{ __("Correo electrónico") }}</th>
    <th class="text-center" nowrap>{{ __("Celular") }}</th>
    <th></th>
@endsection
@section('Body')
    @forelse($sellers as $seller)
        <tr class="text-center">
            <td>
                <a href="{{ route('sellers.show', $seller) }}">
                    {{ $seller->type_document->name }} {{ $seller->document }}
                </a>
            </td>
            <td>{{ $seller->fullname }}</td>
            <td>{{ $seller->email }}</td>
            <td>{{ $seller->cellphone }}</td>
            <td class="btn-group btn-group-sm" nowrap>
                @include('sellers._buttons')
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="6" class="p-3">
                <p class="alert alert-secondary text-center">
                    {{ __('No se encontraron vendedores') }}
                </p>
            </td>
        </tr>
    @endforelse
@endsection
@section('Links')
    {{ $sellers->appends($request->all())->links() }}
@endsection
