@extends('layouts.app')
@section('title', 'Editar contraseña')
@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title text-center">{{ __("Cambiar contraseña") }}</h3>
        </div>
        <div class="card-body">
            <form action="{{ route("users.update-password", $user) }}" class="form-group" method="POST">
                @method('PUT')
                @csrf
                <div class="form-group">
                    <label class="required" for="current_password">{{ __("Contraseña actual") }}</label>
                    <div class="input-group form-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-key"></i></span>
                        </div>
                        <input id="current_password" name="current_password" type="password" placeholder="Ingresa la contraseña actual"
                               class="form-control @error('current_password') is-invalid @enderror" required>
                        @error('current_password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="form-group">
                    <label for="new_password" class="required">
                        {{ __("Contraseña nueva") }}
                    </label>
                    <div class="input-group form-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-key"></i></span>
                        </div>
                        <input id="new_password" name="new_password" type="password" placeholder="Ingresa la contraseña"
                               autocomplete="new_password" minlength="8"
                               class="form-control @error('new_password') is-invalid @enderror" required>
                        @error('new_password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <label for="new_password_confirmation" class="required">
                    {{ __("Confirmar contraseña nueva") }}
                </label>
                <div class="form-group">
                    <div class="input-group form-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-key"></i></span>
                        </div>
                        <input id="new_password_confirmation" name="new_password_confirmation" type="password"
                               placeholder="Confirma la contraseña" autocomplete="new_password"
                               class="form-control" required>
                    </div>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-success">
                        <i class="fa fa-save"></i> {{ __("Actualizar") }}
                    </button>
                    <a href="{{ route('users.show', $user) }}" class="btn btn-secondary">
                        <i class="fa fa-arrow-left"></i> {{ __("Volver") }}
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
