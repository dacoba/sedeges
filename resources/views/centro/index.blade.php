@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mt-4 mb-3">Centros
            <small>Mostrar</small>
        </h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ url('/') }}">Principal</a>
            </li>
            <li class="breadcrumb-item active">Mostrar Centros</li>
        </ol>
        @include('messages')
        <div class="card mb-5">
            <div class="card-header">
                <i class="fa fa-table"></i> Centros Registrados</div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-sm" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th>Nombre del Centro</th>
                            <th>Nombre del Director</th>
                            <th>Telefono</th>
                            <th>Accion</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>Nombre del Centro</th>
                            <th>Nombre del Director</th>
                            <th>Telefono</th>
                            <th>Accion</th>
                        </tr>
                        </tfoot>
                        <tbody>
                        @foreach($centros as $centro)
                            <tr>
                                <td>{{ $centro['nombre_centro'] }}</td>
                                <td>{{ $centro['nombre_director'] }}</td>
                                <td class="text-right">{{ $centro['telefono'] }}</td>
                                <td class="text-center">
                                    <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Mostrar">
                                        <a href="{{ url('centro') }}/{{ $centro['id'] }}">
                                            <i class="fa fa-eye text-primary"></i>
                                        </a>
                                    </span>
                                    <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Modificar">
                                        <a href="{{ url('centro') }}/{{ $centro['id'] }}/edit">
                                            <i class="fa fa-pencil text-warning"></i>
                                        </a>
                                    </span>
                                    @if (Auth::user()->rol == 'Administrador')
                                        <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Eliminar">
                                            <a href="{{ url('centro') }}/{{ $centro['id'] }}" onclick="event.preventDefault();
                                                         document.getElementById('delete-form-{{ $centro["id"] }}').submit();">
                                                <i class="fa fa-trash text-danger" title data-original-title="Delete"></i>
                                            </a>
                                            <form id="delete-form-{{ $centro['id'] }}" action="{{ url('centro') }}/{{ $centro['id'] }}" method="POST" style="display: none;">
                                                {{ csrf_field() }}
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                <input type="hidden" name="_method" value="DELETE" >
                                            </form>
                                        </span>
                                    @endif
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


