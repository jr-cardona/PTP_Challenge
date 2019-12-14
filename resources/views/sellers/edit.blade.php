@extends('layouts.app')
@section('title', 'Editar Vendedor')
@section('content')
    <div class="card">
        <div class="card-header">
            <h1>{{ __("Editar") }} {{ $seller->name }}</h1>
        </div>
        <div class="card-body">
            <form action="{{ route('sellers.update', $seller) }}" class="form-group" method="POST">
                @method('PUT')
                @include('sellers._form')
            </form>
        </div>
    </div>
@endsection
