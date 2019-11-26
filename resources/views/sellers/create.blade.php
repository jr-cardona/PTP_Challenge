@extends('layouts.app')
@section('title', 'Crear Vendedor')
@section('content')
    <div class="card">
        <div class="card-header">
            <h1>Crear Vendedor</h1>
        </div>
        <div class="card-body">
            <form action="{{ route('sellers.store') }}" class="form-group" method="POST">
                @include('sellers._form')
            </form>
        </div>
    </div>
@endsection
