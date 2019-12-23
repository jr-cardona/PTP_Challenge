@extends('layouts.app')
@section('title', 'Crear Cliente')
@section('content')
    <div class="card">
        <div class="card-header">
            <h1>{{ __("Crear Cliente") }}</h1>
        </div>
        <div class="card-body">
            <form action="{{ route('clients.store') }}" class="form-group" method="POST">
                @include('clients._form')
            </form>
        </div>
    </div>
@endsection
