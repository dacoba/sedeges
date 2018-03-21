@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mt-4 mb-3">Solicitudes de Adopcion
            <small>Mostrar</small>
        </h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ url('/') }}">Principal</a>
            </li>
            <li class="breadcrumb-item active">Mostrar Solicitudes de Adopcion</li>
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
                <i class="fa fa-table"></i> Solicitudes Registrados</div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-sm" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th>CI del Adoptante</th>
                            <th>Nombre del Adoptante</th>
                            <th>Estado</th>
                            <th>Fecha de la Solicitud</th>
                            <th>Accion</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>CI del Adoptante</th>
                            <th>Nombre del Adoptante</th>
                            <th>Estado</th>
                            <th>Fecha de la Solicitud</th>
                            <th>Accion</th>
                        </tr>
                        </tfoot>
                        <tbody>
                        @foreach($solicitudes as $solicitud)
                            <tr>
                                <td class="text-right">{{ $solicitud['adoptante']['user']['ci'] }} <strong>{{ $solicitud['adoptante']['user']['ci_extencion'] }}</strong></td>
                                <td>{{ $solicitud['adoptante']['user']['nombres'] }} {{ $solicitud['adoptante']['user']['apellido_paterno'] }} {{ $solicitud['adoptante']['user']['apellido_materno'] }}</td>
                                <td>{{ $estados_solicitud[$solicitud['estado']] }}</td>
                                <td class="text-right">{{ $solicitud['created_at']->diffForHumans() }} - ({{ $solicitud['created_at']->format('F d, Y') }})</td>
                                <td class="text-center">
                                    <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Mostrar">
                                        <a href="{{ url('solicitud') }}/{{ $solicitud['id'] }}">
                                            <i class="fa fa-eye text-primary"></i>
                                        </a>
                                    </span>
                                    <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Modificar">
                                        <a href="{{ url('solicitud') }}/{{ $solicitud['id'] }}/edit">
                                            <i class="fa fa-pencil text-warning"></i>
                                        </a>
                                    </span>
                                    <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Eliminar">
                                        <a href="{{ url('solicitud') }}/{{ $solicitud['id'] }}" onclick="event.preventDefault();
                                                     document.getElementById('delete-form-{{ $solicitud["id"] }}').submit();">
                                            <i class="fa fa-trash text-danger" title data-original-title="Delete"></i>
                                        </a>
                                        <form id="delete-form-{{ $solicitud['id'] }}" action="{{ url('solicitud') }}/{{ $solicitud['id'] }}" method="POST" style="display: none;">
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


