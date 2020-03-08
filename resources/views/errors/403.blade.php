@extends('errors.app')
@section('title', '403')
@section('body')
    <div class="container">
        <div class="row text-center">
            <div class="col-lg-6 offset-lg-3 col-sm-6 offset-sm-3 col-12 p-3 error-main">
                <div class="row">
                    <div class="col-lg-8 col-12 col-sm-10 offset-lg-2 offset-sm-1">
                        <h1 class="m-0">403</h1>
                        <h6>{{ __("Página no autorizada | RetoPTP") }}</h6>
                        <p>
                            {{ __("Regresar a ") }}<a href="{{ route('home') }}">{{ __("Inicio") }}</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
