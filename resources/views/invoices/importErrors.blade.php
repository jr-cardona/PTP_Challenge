@extends('layouts.app')
@section('title', 'Errores de importación')
@section('content')
    <a href="{{ route('invoices.index') }}" class="btn btn-secondary">
        <i class="fa fa-arrow-left"></i> Volver
    </a>
    <p></p>
    <div class="card card-default">
        <div class="card-header">
            <h5 class="card-title mb-0 text-center">Listado de errores</h5>
        </div>
        <div class="table-responsive-lg">
            <table class="table">
                <thead>
                <tr class="text-center">
                    <th>Fila #</th>
                    <th>Campos fallidos</th>
                    <th>Mensajes de error</th>
                </tr>
                </thead>
                <tbody>
                    @foreach($failures as $row => $errors)
                        <tr class="text-center">
                            <td rowspan="{{ count($errors) }}" class="align-middle">{{ $row }}</td>
                            @foreach($errors as $field => $error)
                                <td>{{ $field }}</td>
                                <td>{{ $error }}</td>
                                </tr>
                                <tr class="text-center">
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
