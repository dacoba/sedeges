@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mt-4 mb-3">Usuarios
            <small>Mostrar</small>
            <button class="btn btn-primary hidden-print pull-right" onclick="window.print()"><i class="fa fa-print" aria-hidden="true"></i> Imprimir</button>
        </h1>
        <ol class="breadcrumb hidden-print">
            <li class="breadcrumb-item">
                <a href="{{ url('/') }}">Principal</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ url('/centro') }}">Mostrar Centros</a>
            </li>
            <li class="breadcrumb-item active">Mostrar Detalles</li>
        </ol>
        <div class="card mb-5">
            <div class="card-header">
                <i class="fa fa-table"></i> Datos del Centro</div>
            <div class="card-body">
                <table class="table table-sm">
                    <thead>
                    <tr>
                        <th scope="col">Nombre del Campo</th>
                        <th scope="col">Valor</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <th scope="row">Nombre del Centro</th>
                        <td>{{ $centro['nombre_centro'] }}</td>
                    </tr>
                    <tr>
                        <th scope="row">Telefono</th>
                        <td>{{ $centro['telefono'] }} <i class="fa fa-phone"></i></td>
                    </tr>
                    <tr>
                        <th scope="row">Nombre del Director</th>
                        <td>{{ $centro['nombre_director'] }}</td>
                    </tr>
                    <tr>
                        <th scope="row">Direccion</th>
                        <td>{{ $centro['direccion'] }}</td>
                    </tr>
                    <tr>
                        <th scope="row">Fecha de Fundacion</th>
                        <td>{{ $centro['fecha_fundacion'] }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection


