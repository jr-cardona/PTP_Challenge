@extends('auth.app')
@section('title', 'Recuperar contreseña')
@section('body')
    <form method="POST" action="{{ route('password.email') }}">
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
        <div class="form-group">
            <button type="submit" class="btn btn-block btn-login mt-4">
                {{ __('Enviar solicitud de recuperación') }}
            </button>
        </div>
    </form>
@endsection
@section('footer')
    <div class="d-flex justify-content-center links">
        {{ __("¿Ya tienes una cuenta?") }}<a href="{{ route('login') }}">
            {{ __('Iniciar sesión') }}
        </a>
    </div>
@endsection
