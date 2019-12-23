@extends('layouts.app')
@section('title', 'Home')
@section('content')
        <div class="card card-default">
            <div class="card-header">
                <h1 class="card-title mb-0">{{ __("¡Bienvenido!") }}</h1>
            </div>

            <div class="card-body mb-4">
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                <div class="row">
                    <div class="col">
                        <h1 class="card-title mb-5">{{ __("Reto de desarrolladores Junior Place to Pay") }}</h1>
                    </div>
                </div>
                <div class="row">
                    <div class="col">{{ __("Proyecto basado en un sistema de facturación hecho con el framework laravel 6.
                        En el repositorio de Github puede encontrar el código fuente del proyecto.") }}
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="row">
                    <div class="col">
                        <strong>{{ __("Desarrollado por:") }} </strong>
                        Juan Ricardo Cardona Álvarez
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <strong>{{ __("Link de interés:") }} </strong>
                        <a href="https://github.com/Jricardo745/PTP_Challenge" target="_blank">Github</a>
                    </div>
                </div>
            </div>
        </div>
@endsection
