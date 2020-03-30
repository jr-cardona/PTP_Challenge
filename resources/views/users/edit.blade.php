@extends('layouts.app')
@section('title', 'Editar Usuario')
@section('content')
    <form action="{{ route('users.update', $user) }}" class="form-group" method="POST">
        @csrf
        @method('PUT')
        @include('users._form')
        <br/>
        <div class="form-group">
            <button type="submit" class="btn btn-success btn-block">
                <i class="fa fa-save"></i> {{ __("Actualizar") }}
            </button>
            <a href="{{ route("users.show", $user) }}" class="btn btn-secondary btn-block">
                <i class="fa fa-arrow-left"></i> {{ __("Volver") }}
            </a>
        </div>
    </form>
@endsection
