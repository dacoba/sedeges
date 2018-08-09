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
                    <tbody>
                    <tr>
                        <th scope="row">Nombre del Centro</th>
                        <td>{{ $centro['nombre_centro'] }}</td>
                    </tr>
                    <tr>
                        <th scope="row">Capacidad</th>
                        <td>{{ $centro['capacidad'] }}</td>
                    </tr>
                    <tr>
                        <th scope="row">Cantidad de Infantes</th>
                        <td>{{ $centro->infantes->count() }}</td>
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
                        <th scope="row">Dirección</th>
                        <td>{{ $centro['direccion'] }}</td>
                    </tr>
                    <tr>
                        <th scope="row">Fecha de Fundación</th>
                        <td>{{ $centro['fecha_fundacion'] }}</td>
                    </tr>
                    </tbody>
                </table>

                <div class="table-responsive">
                    <table class="table table-bordered table-sm" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th></th>
                            <th>Nombre</th>
                            <th>Edad (Años)</th>
                            <th>Centro</th>
                            <th>Habilitado</th>
                            <th>Adoptado</th>
                            <th>Acción</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th></th>
                            <th>Nombre</th>
                            <th>Edad (Años)</th>
                            <th>Centro</th>
                            <th>Habilitado</th>
                            <th>Adoptado</th>
                            <th>Acción</th>
                        </tr>
                        </tfoot>
                        <tbody>
                        @foreach($centro->infantes as $infante)
                            <tr>
                                <td></td>
                                <td>{{ $infante['nombre'] }}</td>
                                <td class="text-right">{{ $infante['fecha_nacimiento']->diffInYears(now()) }}</td>
                                <td>{{ $infante['centro']['nombre_centro'] }}</td>
                                <td class="text-center">
                                    @if($infante['habilitado'])
                                        <i class="fa fa-check text-success"></i>
                                    @else
                                        <i class="fa fa-times text-danger"></i>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if($infante['adoptado'])
                                        <i class="fa fa-check text-success"></i>
                                    @else
                                        <i class="fa fa-times text-danger"></i>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Mostrar">
                                        <a href="{{ url('infante') }}/{{ $infante['id'] }}">
                                            <i class="fa fa-eye text-primary"></i>
                                        </a>
                                    </span>
                                    <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Modificar">
                                        <a href="{{ url('infante') }}/{{ $infante['id'] }}/edit">
                                            <i class="fa fa-pencil text-warning"></i>
                                        </a>
                                    </span>
                                    <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Eliminar">
                                        <a href="{{ url('infante') }}/{{ $infante['id'] }}" onclick="event.preventDefault();
                                                document.getElementById('delete-form-{{ $infante["id"] }}').submit();">
                                            <i class="fa fa-trash text-danger" title data-original-title="Delete"></i>
                                        </a>
                                        <form id="delete-form-{{ $infante['id'] }}" action="{{ url('infante') }}/{{ $infante['id'] }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <input type="hidden" name="_method" value="DELETE" >
                                        </form>
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection


