@extends('layouts.app')
@section('title', 'Crear Factura')
@section('content')
    <div class="card">
        <div class="card-header">
            <h1>{{ __("Crear Factura") }}</h1>
        </div>
        <div class="card-body">
            <form action="{{ route('invoices.store') }}" class="form-group" method="POST">
                @include('invoices._form')
            </form>
        </div>
    </div>
@endsection
