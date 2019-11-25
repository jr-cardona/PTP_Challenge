@extends('layouts.app')
@section('title', 'Vendedores')
@section('content')
    <div class="row">
        <div class="col">
            <h1>Vendedores</h1>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <a class="btn btn-success" href="{{ route('sellers.create') }}">Crear nuevo vendedor</a>
        </div>
    </div>
    <br>
    {{ $sellers->links() }}
    <table class="table border-rounded table-striped">
        <thead class="thead-dark">
            <tr class="text-center">
                <th scope="col">Documento</th>
                <th scope="col" nowrap>Nombre</th>
                <th scope="col">Dirección</th>
                <th scope="col">Correo electrónico</th>
                <th scope="col">Celular</th>
                <th scope="col" colspan="2">Opciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sellers as $seller)
                <tr class="text-center">
                    <td>
                        <a href="{{ route('sellers.show', $seller) }}" target="_blank">
                            {{ $seller->type_document->name }} {{ $seller->document }}
                        </a>
                    </td>
                    <td>{{ $seller->name }}</td>
                    <td>{{ $seller->address }}</td>
                    <td>{{ $seller->email }}</td>
                    <td>{{ $seller->cell_phone_number }}</td>
                    @include('sellers._buttons')
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
