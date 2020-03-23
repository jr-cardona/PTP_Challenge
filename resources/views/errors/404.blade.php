@extends('layouts.errors')
@section('title', '404')
@section('body')
    <div class="container">
        <div class="row text-center">
            <div class="col p-3 error-main">
                <div class="row">
                    <div class="col-lg-8 col-12 col-sm-10 offset-lg-2 offset-sm-1">
                        <h1 class="m-0">404</h1>
                        <h2>{{ __("Página no encontrada | RetoPTP") }}</h2>
                        <h4>
                            {{ __("Regresar a ") }}<a href="{{ route('home') }}">{{ __("Inicio") }}</a>
                        </h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
