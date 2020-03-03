@extends('layouts.app')
@section('title', 'Reportes')
@section('content')
    <div class="card card-default">
        <div class="shadow">
            <div class="card-header">
                <h2 class="card-title mb-0">Seleccione el reporte deseado</h2>
            </div>
            <div class="card-body">
                <ul>
                    <li><a href="{{ route('reports.clients') }}">Reporte de clientes deudores</a></li>
                    <li><a href="#">Reporte de ventas por vendedor</a></li>
                    <li><a href="#">Reporte de recaudos</a></li>
                </ul>
            </div>
        </div>
    </div>
@endsection
