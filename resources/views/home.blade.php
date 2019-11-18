@extends('layouts.app')
@section('title', 'Home')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="card">
            <div class="card-header">
                <h1>¡Bienvenido!</h1>
            </div>

            <div class="card-body">
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                <div class="container px-2">
                    <h1 class="h1" style="margin-top:30px;margin-bottom:20px">Reto de desarrolladores Junior Place to Pay</h1>
                </div>
                <div class="row" style="padding:20px">
                    <p>Proyecto basado en un sistema de facturación hecho con el framework laravel 6.
                        En el repositorio de Github puede encontrar el código fuente del proyecto.</p>
                </div>
                <div class="row" style="padding: 10px">
                    <p>
                        <strong>Desarrollado por: </strong>
                        Juan Ricardo Cardona Álvarez
                    </p>
                </div>
                <div class="row" style="padding: 10px">
                    <p>
                        <strong>Link de interés: </strong>
                        <a href="https://github.com/Jricardo745/Facturation-system" target="_blank">Github</a></li>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
