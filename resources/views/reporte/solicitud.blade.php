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
            <li class="breadcrumb-item">
                <a href="{{ url('/reporte/solicitud') }}">Reporte de Solicitud</a>
            </li>
            <li class="breadcrumb-item active">Reporte</li>
        </ol>
        <div class="card mb-5">
            <div class="card-header">
                <i class="fa fa-table"></i> Solicitudes
                <span class="pull-right">del {{$date_from->format('j \d\e F \d\e\l Y')}} al {{$date_to->format('j \d\e F \d\e\l Y')}}</span>
            </div>
            <div class="card-body">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="resumen-tab" data-toggle="tab" href="#resumen" role="tab" aria-controls="resumen" aria-selected="true">Resumen</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="lista-tab" data-toggle="tab" href="#lista" role="tab" aria-controls="lista" aria-selected="false">Solicitudes</a>
                    </li>
                </ul>
                <br>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="resumen" role="tabpanel" aria-labelledby="resumen-tab">
                        <div class="row">
                            <div class="col-sm-6 d-flex">
                                <div class="card w-100 card-block">
                                    <div class="card-body text-center my-auto d-table">
                                        <div class="align-self-center d-table-cell align-middle">
                                            <h1 class="card-title">{{$solicitudes_registradas}}</h1>
                                            <p class="card-text">Solicitudes registradas.</p>
                                            @if(isset($estado_definido) && $valores != [0])
                                                <br>
                                                <h1 class="card-title">{{$valores[0]}}</h1>
                                                <p class="card-text">Solicitudes en estado {{ $estados[0] }}.</p>
                                            @endif
                                        </div>

                                        {{--<a href="#" class="btn btn-primary">Go somewhere</a>--}}
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="card">
                                    <div class="card-body text-center">
                                        @if($valores == [0])
                                            <h1 class="card-title">0</h1>
                                            <p class="card-text">Solicitudes en estado {{ $estados[0] }}.</p>
                                        @else
                                            <canvas id="myPieChart" width="100%" height="80"></canvas>
                                        @endif
                                        {{--<a href="#" class="btn btn-primary">Go somewhere</a>--}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="lista" role="tabpanel" aria-labelledby="lista-tab">
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                <tr>
                                    <th></th>
                                    <th>CI del Adoptante</th>
                                    <th>Nombre del Adoptante</th>
                                    <th>Estado</th>
                                    <th>Fecha de la Solicitud</th>
                                    <th>Acción</th>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th></th>
                                    <th>CI del Adoptante</th>
                                    <th>Nombre del Adoptante</th>
                                    <th>Estado</th>
                                    <th>Fecha de la Solicitud</th>
                                    <th>Acción</th>
                                </tr>
                                </tfoot>
                                <tbody>
                                @foreach($solicitudes as $solicitud)
                                    <tr>
                                        <td></td>
                                        <td class="text-right">{{ $solicitud['adoptante']['user']['ci'] }} <strong>{{ $solicitud['adoptante']['user']['ci_extencion'] }}</strong></td>
                                        <td>{{ $solicitud['adoptante']['user']['nombres'] }} {{ $solicitud['adoptante']['user']['apellido_paterno'] }} {{ $solicitud['adoptante']['user']['apellido_materno'] }}</td>
                                        <td>{{ $estados_solicitud[$solicitud['estado']] }}</td>
                                        <td class="text-right">{{ $solicitud['created_at']->diffForHumans() }} - ({{ $solicitud['created_at']->format('F d, Y') }})</td>
                                        <td class="text-center">
                                            <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Mostrar">
                                                <a href="{{ url('reporte/solicitud') }}/{{ $solicitud['id'] }}">
                                                    <i class="fa fa-eye text-primary"></i>
                                                </a>
                                            </span>
                                            {{--<span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Modificar">--}}
                                                {{--<a href="{{ url('solicitud') }}/{{ $solicitud['id'] }}/edit">--}}
                                                    {{--<i class="fa fa-pencil text-warning"></i>--}}
                                                {{--</a>--}}
                                            {{--</span>--}}
                                            {{--<span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Eliminar">--}}
                                            {{--<a href="{{ url('solicitud') }}/{{ $solicitud['id'] }}" onclick="event.preventDefault();--}}
                                            {{--document.getElementById('delete-form-{{ $solicitud["id"] }}').submit();">--}}
                                            {{--<i class="fa fa-trash text-danger" title data-original-title="Delete"></i>--}}
                                            {{--</a>--}}
                                            {{--<form id="delete-form-{{ $solicitud['id'] }}" action="{{ url('solicitud') }}/{{ $solicitud['id'] }}" method="POST" style="display: none;">--}}
                                            {{--{{ csrf_field() }}--}}
                                            {{--<input type="hidden" name="_token" value="{{ csrf_token() }}">--}}
                                            {{--<input type="hidden" name="_method" value="DELETE" >--}}
                                            {{--</form>--}}
                                            {{--</span>--}}
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            {{--<div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>--}}
        </div>
    </div>
    <script src="{{ asset('js/Chart.min.js') }}"></script>
    <script>
        // -- Pie Chart Example
        var ctx = document.getElementById("myPieChart");
        var myPieChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: <?=json_encode($estados)?>,
                datasets: [{
                    data: <?=json_encode($valores)?>,
                    backgroundColor: [
                        '#007bff',
                        '#dc3545',
                        '#ffc107',
                        '#28a745',
                        '#7D3C98'
                    ]
                }]
            },
            options: {
                legend: {
                    position: 'bottom'
                }
            }
        });
    </script>
@endsection


