@extends('auth.app')
@section('title')
    {{ __("Iniciar sesión") }}
@endsection
@section('body')
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="input-group form-group">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
            </div>
            <input id="email" name="email" type="email" placeholder="Correo electrónico" autocomplete="email"
                   class="form-control @error('email') is-invalid @enderror" required autofocus>
            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="input-group form-group">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-key"></i></span>
            </div>
            <input id="password" name="password" type="password" placeholder="Contraseña" autocomplete="current-password"
                   class="form-control @error('password') is-invalid @enderror" required>
            @error('password')
            <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="row align-items-center remember">
            <input id="remember" name="remember" type="checkbox" {{ old('remember') ? 'checked' : '' }}>
            {{ __("Recuérdame") }}
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-block btn-login mt-4">
                {{ __('Ingresar') }}
            </button>
        </div>
    </form>
@endsection
@section('footer')
    <div class="d-flex justify-content-center links">
        {{ __("¿Olvidaste la contraseña?") }}<a href="{{ route('password.request') }}">
            {{ __("Click aquí") }}
        </a>
    </div>
@endsection
