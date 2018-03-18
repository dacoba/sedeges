@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mt-4 mb-3">Infantes
            <small>Mostrar</small>
        </h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ url('/') }}">Principal</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ url('/infante') }}">Mostrar Infantes</a>
            </li>
            <li class="breadcrumb-item active">Mostrar Detalles</li>
        </ol>
        <div class="card mb-5">
            <div class="card-header">
                <i class="fa fa-table"></i> Datos del Infante</div>
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
                        <th scope="row">Nombre del Infante</th>
                        <td>{{ $infante['nombre'] }}</td>
                    </tr>
                    <tr>
                        <th scope="row">CI</th>
                        <td>{{ $infante['ci'] }} {{ $infante['ci_extencion'] }}</td>
                    </tr>
                    <tr>
                        <th scope="row">Fecha de Nacimiento</th>
                        <td>{{ $infante['fecha_nacimiento'] }}</td>
                    </tr>
                    <tr>
                        <th scope="row">Centro al que Pertenece</th>
                        <td>{{ $infante['centro']['nombre_centro'] }}</td>
                    </tr>
                    <tr>
                        <th scope="row">Fecha de Ingreso al Centro</th>
                        <td>{{ $infante['fecha_ingreso'] }}</td>
                    </tr>
                    <tr>
                        <th scope="row">Habilitado</th>
                        <td>
                            @if($infante['habilitado']) Si @else No @endif
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">Adoptado</th>
                        <td>
                            @if($infante['adoptado']) Si @else No @endif
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection


