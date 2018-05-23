@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mt-4 mb-3">Reporte
            <small>Solicitud</small>
        </h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ url('/') }}">Principal</a>
            </li>
            <li class="breadcrumb-item active">Reporte de Solicitud</li>
        </ol>
        <div class="card mb-5">
            <div class="card-header">
                <i class="fa fa-table"></i> Solicitudes</div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 offset-md-4">
                        <form method="POST" action="{{ url('/reporte/solicitud') }}">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="date_from">Fecha de Inicio</label>
                                <input type="date" class="form-control text-right" id="date_from" name="date_from" value="{{ $date_from or old('date_from')}}">
                            </div>
                            <div class="form-group">
                                <label for="date_to">Fecha de fin</label>
                                <input type="date" class="form-control text-right" id="date_to" name="date_to" value="{{ $date_to or old('date_to')}}">
                            </div>
                            <div class="form-group">
                                <label for="centro_id">Estado</label>
                                <select class="form-control" name="estado">
                                    <option value="-1">Todos</option>
                                    @foreach($estados_solicitud as $item)
                                        <option value="{{ key($estados_solicitud) }}">{{ $item }}</option>
                                        @php(next($estados_solicitud))
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block mb-2">Cargar Reporte</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="card-footer small text-muted text-right">Fecha Actual: {{date('d/m/Y')}}</div>
        </div>
    </div>
@endsection


