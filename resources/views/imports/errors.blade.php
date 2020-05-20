@extends('layouts.index')
@section('Title', 'Errores de importación')
@section('Left-buttons')
    <a href="{{ url()->previous() }}" class="btn btn-secondary">
        <i class="fa fa-arrow-left"></i> {{ __("Volver") }}
    </a>
@endsection
@section('Name')
{{ __("Listado de errores") }}
@endsection
@section('Header')
    <tr class="text-center">
        <th>{{ __("Fila") }} #</th>
        <th>{{ __("Campos fallidos") }}</th>
        <th>{{ __("Mensajes de error") }}</th>
    </tr>
@endsection
@section('Body')
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
@endsection
