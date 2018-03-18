@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mt-4 mb-3">Usuarios
            <small>Mostrar</small>
        </h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ url('/') }}">Principal</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ url('/usuario') }}">Mostrar Usuarios</a>
            </li>
            <li class="breadcrumb-item active">Mostrar Detalles</li>
        </ol>
        <div class="card mb-5">
            <div class="card-header">
                <i class="fa fa-table"></i> Datos del Usuario</div>
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
                        <td>{{ $usuario['ci'] }} {{ $usuario['ci_extencion'] }}</td>
                    </tr>
                    <tr>
                        <th scope="row">Nombre</th>
                        <td>{{ $usuario['nombres'] }} {{ $usuario['apellido_paterno'] }} {{ $usuario['apellido_materno'] }}</td>
                    </tr>
                    <tr>
                        <th scope="row">Rol</th>
                        <td>{{ $usuario['rol'] }}</td>
                    </tr>
                    <tr>
                        <th scope="row">Email</th>
                        <td>{{ $usuario['email'] }}</td>
                    </tr>
                    <tr>
                        <th scope="row">Fecha Nacimiento</th>
                        <td>{{ $usuario['fecha_nacimiento'] }}</td>
                    </tr>
                    <tr>
                        <th scope="row">Telefono Fijo</th>
                        <td>{{ $usuario['telefono_fijo'] }} <i class="fa fa-phone"></i></td>
                    </tr>
                    <tr>
                        <th scope="row">Telefono Celular</th>
                        <td>{{ $usuario['telefono_celular'] }} <i class="fa fa-mobile"></i></td>
                    </tr>
                    <tr>
                        <th scope="row">Desabilitado</th>
                        <td>{{ $usuario['desabilitado'] }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection


