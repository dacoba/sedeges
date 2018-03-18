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
            <li class="breadcrumb-item active">Mostrar Usuarios</li>
        </ol>
        @if(isset($message['success']) and $message['success'])
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Satisfactorio!</strong> {{ $message['success_message'] }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        @if(isset($message['error']) and $message['error'])
            <div class="alert alert-error alert-dismissible fade show" role="alert">
                <strong>Fallo!</strong> {{ $message['error_message'] }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        <div class="card mb-5">
            <div class="card-header">
                <i class="fa fa-table"></i> Usuarios Registrados</div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th>CI</th>
                            <th>Nombre</th>
                            <th>Rol</th>
                            <th>Email</th>
                            <th>Fecha Nacimiento</th>
                            <th>Accion</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>CI</th>
                            <th>Nombre</th>
                            <th>Rol</th>
                            <th>Email</th>
                            <th>Fecha Nacimiento</th>
                            <th>Accion</th>
                        </tr>
                        </tfoot>
                        <tbody>
                        @foreach($usuarios as $usuario)
                            <tr>
                                <td class="text-right">{{ $usuario['ci'] }} <strong>{{ $usuario['ci_extencion'] }}</strong></td>
                                <td>{{ $usuario['nombres'] }} {{ $usuario['apellido_paterno'] }} {{ $usuario['apellido_materno'] }}</td>
                                <td>{{ $usuario['rol'] }}</td>
                                <td>{{ $usuario['email'] }}</td>
                                <td class="text-right">{{ $usuario['fecha_nacimiento'] }}</td>
                                <td class="text-center">
                                    <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Mostrar">
                                        <a href="{{ url('usuario') }}/{{ $usuario['id'] }}">
                                            <i class="fa fa-eye text-primary"></i>
                                        </a>
                                    </span>
                                    <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Modificar">
                                        <a href="{{ url('usuario') }}/{{ $usuario['id'] }}/edit">
                                            <i class="fa fa-pencil text-warning"></i>
                                        </a>
                                    </span>
                                    <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Eliminar">
                                        <a href="{{ url('usuario') }}/{{ $usuario['id'] }}" onclick="event.preventDefault();
                                                     document.getElementById('delete-form-{{ $usuario["id"] }}').submit();">
                                            <i class="fa fa-trash text-danger" title data-original-title="Delete"></i>
                                        </a>
                                        <form id="delete-form-{{ $usuario['id'] }}" action="{{ url('usuario') }}/{{ $usuario['id'] }}" method="POST" style="display: none;">
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
            {{--<div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>--}}
        </div>
    </div>
@endsection


