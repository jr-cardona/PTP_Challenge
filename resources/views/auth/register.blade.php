@extends('auth.app')
@section('title')
    {{ __("Registrar") }}
@endsection
@section('body')
    <form method="POST" action="{{ route('register') }}">
        @csrf
        <div class="input-group form-group">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-user"></i></span>
            </div>
            <input id="name" name="name" type="text" placeholder="Nombre completo" autocomplete="name"
                   class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required autofocus>
            @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="input-group form-group">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
            </div>
            <input id="email" name="email" type="email" placeholder="Correo electrónico" autocomplete="email"
                   class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required autofocus>
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
            <input id="password" name="password" type="password" placeholder="Contraseña" autocomplete="new-password"
                   class="form-control @error('password') is-invalid @enderror" required>
            @error('password')
            <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="input-group form-group">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-key"></i></span>
            </div>
            <input id="password-confirm" name="password_confirmation" type="password" placeholder="Confirmar contraseña" autocomplete="new-password"
                   class="form-control" required>
        </div>
        <div class="form-group">
            <input type="submit" value="Registrar" class="btn float-right login_btn">
        </div>
    </form>
@endsection
@section('footer')
    <div class="d-flex justify-content-center links">
        {{ __("¿Ya tienes una cuenta?") }}<a href="{{ route('login') }}">{{ __("Iniciar sesión") }}</a>
    </div>
@endsection
