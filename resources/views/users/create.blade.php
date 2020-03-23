@extends('layouts.app')
@section('title', 'Crear Usuario')
@section('content')
    <form action="{{ route('users.store') }}" class="form-group" method="POST">
        @csrf
        @include('users._form')
        <br/>
        <div class="form-group">
            <button type="submit" class="btn btn-success btn-block">
                <i class="fa fa-save"></i> {{ __("Guardar") }}
            </button>
            <a href="{{ route("users.index") }}" class="btn btn-secondary btn-block">
                <i class="fa fa-arrow-left"></i> {{ __("Volver") }}
            </a>
        </div>
    </form>
@endsection
