@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mt-4 mb-3">Adoptantes
            <small>Mostrar</small>
            <button class="btn btn-primary hidden-print pull-right" onclick="window.print()"><i class="fa fa-print" aria-hidden="true"></i> Imprimir</button>
        </h1>
        <ol class="breadcrumb hidden-print">
            <li class="breadcrumb-item">
                <a href="{{ url('/') }}">Principal</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ url('/adoptante') }}">Mostrar Adoptantes</a>
            </li>
            <li class="breadcrumb-item active">Mostrar Detalles</li>
        </ol>
        <div class="card mb-5">
            <div class="card-header">
                <i class="fa fa-table"></i> Datos del Adoptante</div>
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
                        <th scope="row">CI</th>
                        <td>{{ $adoptante['user']['ci'] }} {{ $adoptante['user']['ci_extencion'] }}</td>
                    </tr>
                    <tr>
                        <th scope="row">Nombre</th>
                        <td>{{ $adoptante['user']['nombres'] }} {{ $adoptante['user']['apellido_paterno'] }} {{ $adoptante['user']['apellido_materno'] }}</td>
                    </tr>
                    <tr>
                        <th scope="row">Ocupacion</th>
                        <td>{{ $adoptante['ocupacion'] }}</td>
                    </tr>
                    <tr>
                        <th scope="row">Email</th>
                        <td>{{ $adoptante['user']['email'] }}</td>
                    </tr>
                    <tr>
                        <th scope="row">Fecha Nacimiento</th>
                        <td>{{ $adoptante['user']['fecha_nacimiento']->format('F d, Y') }}</td>
                    </tr>
                    <tr>
                        <th scope="row">Telefono Fijo</th>
                        <td>{{ $adoptante['user']['telefono_fijo'] }} <i class="fa fa-phone"></i></td>
                    </tr>
                    <tr>
                        <th scope="row">Telefono Celular</th>
                        <td>{{ $adoptante['user']['telefono_celular'] }} <i class="fa fa-mobile"></i></td>
                    </tr>
                    <tr>
                        <th scope="row">Estado Civil</th>
                        <td>{{ $adoptante['estado_civil'] }}</td>
                    </tr>
                    <tr>
                        <th scope="row">Direccion</th>
                        <td>{{ $adoptante['direccion'] }}</td>
                    </tr>
                    <tr>
                        <th scope="row">Ocupacion</th>
                        <td>{{ $adoptante['ocupacion'] }}</td>
                    </tr>
                    <tr>
                        <th scope="row">Cuenta Habilitada</th>
                        <td>
                            @if($adoptante['user']['habilitado']) Si @else No @endif
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">Adopcion Habilitada</th>
                        <td>
                            @if($adoptante['habilitado']) Si @else No @endif
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection


