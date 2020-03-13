@extends('layouts.app')
@section('title', 'Confirmar redirección')
@section('content')
            <div class="panel panel-default">
                <form action="{{ route('invoices.payments.store', $invoice) }}" method="post" class="form-horizontal">
                    @csrf
                    <div class="panel-body">
                        <div class="alert alert-info text-center"> {{ __("Estás a punto de pagar") }}
                            <b>${{ number_format($invoice->total, 2) }} COP</b> {{ __("con Place to Pay") }}
                        </div>

                        <h3 class="page-header text-center">{{ __("Información del Comprador") }}</h3>

                        <div class="form-group text-center">
                            {{ __("Nombre:") }} <span class="form-control text-center">{{ $invoice->client->user->name }}</span>
                        </div>

                        <div class="form-group text-center">
                            {{ __("Apellido:") }} <span class="form-control text-center">{{ $invoice->client->user->surname }}</span>
                        </div>

                        <div class="form-group text-center">
                            {{ __("Tipo de documento:") }} <span class="form-control text-center">{{ $invoice->client->type_document->fullname }}</span>
                        </div>

                        <div class="form-group text-center">
                            {{ __("Documento:") }} <span class="form-control text-center">{{ $invoice->client->document }}</span>
                        </div>

                        <div class="form-group text-center">
                            {{ __("Email:") }} <span class="form-control text-center">{{ $invoice->client->user->email }}</span>
                        </div>
                    </div>
                    <div class="panel-footer">
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('invoices.show', $invoice) }}" class="btn btn-secondary pull-left">
                                <i class="fa fa-arrow-left"></i> {{ __("Volver") }}
                            </a>
                            <button type="submit" class="btn btn-primary pull-right">
                                <i class="fas fa-dollar-sign"></i> {{ __("Pagar") }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>

@endsection
