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
            <li class="breadcrumb-item active">Mostrar Infantes</li>
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
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Fallo!</strong> {{ $message['error_message'] }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        <div class="card mb-5">
            <div class="card-header">
                <i class="fa fa-table"></i> Infantes Registrados</div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-sm" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Edad</th>
                            <th>Centro</th>
                            <th>Habilitado</th>
                            <th>Adoptado</th>
                            <th>Accion</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>Nombre</th>
                            <th>Edad</th>
                            <th>Centro</th>
                            <th>Habilitado</th>
                            <th>Adoptado</th>
                            <th>Accion</th>
                        </tr>
                        </tfoot>
                        <tbody>
                        @foreach($infantes as $infante)
                            <tr>
                                <td>{{ $infante['nombre'] }}</td>
                                <td class="text-right">{{ $infante['fecha_nacimiento']->diffInYears(now()) }} años.</td>
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
            {{--<div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>--}}
        </div>
    </div>
@endsection


