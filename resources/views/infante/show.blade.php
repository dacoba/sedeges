@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mt-4 mb-3">Infantes
            <small>Mostrar</small>
            <button class="btn btn-primary hidden-print pull-right" onclick="window.print()"><i class="fa fa-print" aria-hidden="true"></i> Imprimir</button>
        </h1>
        <ol class="breadcrumb hidden-print">
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
                        <th scope="col" style="width: 35%!important;">Nombre del Campo</th>
                        <th scope="col" style="width: 65%!important;">Valor</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <th scope="row">Nombre del Infante</th>
                        <td>{{ $infante['nombre'] }}</td>
                    </tr>
                    <tr>
                        <th scope="row">Genero</th>
                        <td>{{ $infante['genero'] }}</td>
                    </tr>
                    <tr>
                        <th scope="row">Edad</th>
                        <td>{{ $infante['fecha_nacimiento']->diffInYears(now()) }} años.</td>
                    </tr>
                    <tr>
                        <th scope="row">CI</th>
                        <td>{{ $infante['ci'] }} {{ $infante['ci_extencion'] }}</td>
                    </tr>
                    <tr>
                        <th scope="row">Fecha de Nacimiento</th>
                        <td>{{ $infante['fecha_nacimiento']->format('F d, Y') }}</td>
                    </tr>
                    <tr>
                        <th scope="row">Centro al que Pertenece</th>
                        <td>{{ $infante['centro']['nombre_centro'] }}</td>
                    </tr>
                    <tr>
                        <th scope="row">Fecha de Ingreso al Centro</th>
                        <td>{{ $infante['fecha_ingreso']->format('F d, Y')   }}</td>
                    </tr>
                    <tr>
                        <th scope="row">Habilitado para Adopcion</th>
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
                    <tr>
                        <th scope="row">Descripcion</th>
                        <td class="mw-50 text-justify">{{ $infante['descripcion'] }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection


