@extends('layouts.app')
@section('title', 'Editar Cliente')
@section('content')
    <div class="card">
        <div class="card-header">
            <h1>{{ __("Editar") }} {{ $client->name }}</h1>
        </div>
        <div class="card-body">
            <form action="{{ route('clients.update', $client) }}" class="form-group" method="POST">
                @method('PUT')
                @include('clients._form')
                <div class="form-group">
                    <input type="submit" class="btn btn-primary" value="Guardar">
                    <a href="{{ route('clients.show', $client) }}" class="btn btn-danger">{{ __("Volver") }}</a>
                </div>
            </form>
        </div>
    </div>
@endsection
