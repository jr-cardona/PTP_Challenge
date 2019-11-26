@extends('layouts.app')
@section('title', 'Ver Producto')
@section('content')
    <div class="card">
        <div class="card-header">
            <h1>{{ $product->name }}</h1>
        </div>
        <div class="card-body">
            <div class="btn-group">
                @include('products._buttons')
            </div>
            <p></p>
            <table class="table border-rounded table-sm">
                <tr>
                    <td class="table-dark td-title" style="width: 15%; text-align: right">Nombre:</td>
                    <td class="td-content">{{ $product->name }}</td>

                    <td class="table-dark td-title" style="width: 15%; text-align: right">Descripción:</td>
                    <td class="td-content">{{ $product->description }}</td>
                </tr>
                <tr>
                    <td class="table-dark td-title" style="width: 15%; text-align: right">Creado:</td>
                    <td class="td-content">{{ $product->created_at }}</td>

                    <td class="table-dark td-title" style="width: 15%; text-align: right">Modificado:</td>
                    <td class="td-content">{{ $product->updated_at }}</td>
                </tr>
            </table>
        </div>
    </div>
@endsection
