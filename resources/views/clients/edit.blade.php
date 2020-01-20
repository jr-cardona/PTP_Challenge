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
                    <button type="submit" class="btn btn-success">
                        <i class="fa fa-save"></i> {{ __("Guardar") }}
                    </button>
                    <a href="{{ route("clients.show", $client) }}" class="btn btn-secondary">
                        <i class="fa fa-arrow-left"></i> {{ __("Volver") }}
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
