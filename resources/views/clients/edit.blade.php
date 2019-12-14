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
            </form>
        </div>
    </div>
@endsection
