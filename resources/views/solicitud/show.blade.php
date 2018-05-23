@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mt-4 mb-3">Solicitudes de Adopcion
            <small>Modificar</small>
        </h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ url('/') }}">Principal</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ url('/solicitud') }}">Mostrar Solicitudes de Adopcion</a>
            </li>
            <li class="breadcrumb-item active">Modificar</li>
        </ol>
        @if(isset($message['success']) and $message['success'])
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Satisfactorio!</strong> {{ $message['success_message'] }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        <div class="card mb-5">
            <div class="card-header">
                <i class="fa fa-table"></i> Datos de la Solicitud de Adopcion</div>
            <div class="card-body">
                <form class="form-horizontal" id="form_solicitud" method="POST" action="{{ url('/solicitud') }}/{{ $solicitud['id'] }}" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="_method" value="PUT" >
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <label for="adoptante_id" class="col-sm-4 col-form-label">Adoptante</label>
                                    <div class="col-sm-8">
                                        <input class="form-control-plaintext" id="adoptante_id" type="text" name="adoptante_id" value="{{ $solicitud['adoptante']['user']['nombres'] }} {{ $solicitud['adoptante']['user']['apellido_paterno'] }} {{ $solicitud['adoptante']['user']['apellido_materno'] }}" aria-describedby="nameHelp" readonly>
                                    </div>
                                </div>
                                <div class="row">
                                    <label for="created_at" class="col-sm-4 col-form-label">Fecha</label>
                                    <div class="col-sm-8">
                                        <input class="form-control-plaintext" id="created_at" type="text" name="created_at" value="{{ $solicitud['created_at']->format('d \d\e F \d\e\l Y') }}" aria-describedby="nameHelp" readonly>
                                    </div>
                                </div>
                                <div class="row">
                                    <label for="estado" class="col-sm-4 col-form-label">Estado</label>
                                    <div class="col-sm-8">
                                        <input class="form-control-plaintext" id="estado" type="text" name="estado" value="{{ $estados_solicitud[$solicitud['estado']] }}" aria-describedby="nameHelp"readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <label for="infante_genero" class="col-sm-4 col-md-5 col-form-label">Genero del Infante</label>
                                    <div class="col-sm-8 col-md-7">
                                        <input class="form-control-plaintext" id="infante_genero" type="text" name="infante_genero" value="{{ $solicitud['infante_genero'] }}" aria-describedby="nameHelp" readonly>
                                    </div>
                                </div>
                                <div class="row">
                                    <label for="infante_edad" class="col-sm-4 col-md-5 col-form-label">Edad del Infante</label>
                                    <div class="col-sm-8 col-md-7">
                                        <input class="form-control-plaintext" id="infante_edad" type="text" name="infante_edad" value="de {{ $solicitud['infante_edad_desde'] }} a {{ $solicitud['infante_edad_hasta'] }} Años" aria-describedby="nameHelp"readonly>
                                    </div>
                                </div>
                                <div class="row">
                                    @if(is_null($solicitud['infante_id']))
                                        <label for="demanda_adopcion" class="col-sm-4 col-md-5 col-form-label">Demanda de Adopcion</label>
                                        <div class="col-sm-8 col-md-7">
                                            <input class="form-control-plaintext {{ $solicitud['demanda_adopcion'] ? 'font-weight-bold text-uppercase' : '' }}" id="demanda_adopcion" type="text" name="demanda_adopcion" value="{{ $solicitud['demanda_adopcion'] ? "Recibida" : "No Recibida" }}" aria-describedby="nameHelp" readonly>
                                        </div>
                                    @else
                                        <label for="infante_asignado" class="col-sm-4 col-md-5 col-form-label">Infante Asignado</label>
                                        <div class="col-sm-8 col-md-7">
                                            <input class="form-control-plaintext" id="infante_asignado" type="text" name="infante_asignado" value="{{ $solicitud['infante']['nombre'] }}" aria-describedby="nameHelp" readonly>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="cy"></div>
                    <script>
                        var cy = cytoscape({
                            container: document.getElementById('cy'),
                            style: cytoscape.stylesheet()
                                .selector('node')
                                .css({
                                    'content': 'data(name)',
                                    'text-valign': 'bottom',
                                    'color': 'black',
                                    'font-size': "16px",
                                    'font-weight': "bold",
                                    'background-color': 'white',
                                    'background-width': '100%',
                                    'background-height': '100%',
                                    'width': 90,
                                    'height': 90
                                })
                                .selector('edge')
                                .css({
                                    'width': 5,
                                    'line-color': '#999',
                                    'target-arrow-color': '#999',
                                    'target-arrow-shape': 'triangle',
                                    "curve-style": "unbundled-bezier",
                                    "control-point-distances": [-40],

                                })
                                .selector('.highlighted')
                                .css({
                                    'color': '#036aff',
                                    'background-color': '#9bc3f9',
                                    'border-color': '#489df9',
                                    'border-width': '3px',
                                    'line-color': '#489df9',
                                    'target-arrow-color': '#489df9',
                                    'transition-property': 'background-color, line-color, target-arrow-color',
                                    'transition-duration': '0.5s'
                                })
                                .selector('#demand').css({'background-image': '../../img/icon/doc.png'})
                                .selector('#ab2, #ab3').css({'background-image': '../../img/icon/lawyer.png'})
                                .selector('#doc').css({'background-image': '../../img/icon/doctor.png'})
                                .selector('#ps').css({'background-image': '../../img/icon/psicologo.png'})
                                .selector('#secre').css({'background-image': '../../img/icon/secretaria.png'})
                                .selector('#inf').css({'background-image': '../../img/icon/infante.png'})
                                .selector('#cor, #cor2').css({'background-image': '../../img/icon/cordinador2.png'})
                                .selector('#ts, #ts3').css({'background-image': '../../img/icon/trabajador_social.png'})
                                .selector('#cert').css({'background-image': '../../img/icon/certificado.png'})
                                .selector('#secre, #cor, #cor2, #ab2, #ab3')
                                .css({
                                    'background-width': '65%',
                                    'background-height': '65%'
                                })
                                .selector('#doc, #ps, #inf, #ts, #ts3')
                                .css({
                                    'background-width': '75%',
                                    'background-height': '75%'
                                })
                                .selector('#demand, #cert')
                                .css({
                                    'background-width': '50%',
                                    'background-height': '50%'
                                })
                                .selector(':selected'),
                            elements: {
                                nodes: [
                                    { data: { id: 'secre', name: 'Secretaria'}, position: { x: 0, y: 200 }, grabbable: false },
                                    { data: { id: 'cor', name: 'Cordinador'}, position: { x: 200, y: 200 }, grabbable: false  },
                                    { data: { id: 'ts', name: 'Trabajadora Social' }, position: { x: 400, y: 50 }, grabbable: false  },
                                    { data: { id: 'ps', name: 'Psicologo' }, position: { x: 400, y: 200 }, grabbable: false  },
                                    { data: { id: 'doc', name: 'Doctor' }, position: { x: 400, y: 350 }, grabbable: false  },
                                    { data: { id: 'cert', name: 'Certificado de Taller ' }, position: { x: 600, y: 50 }, grabbable: false  },
                                    { data: { id: 'cor2', name: 'Cordinador' }, position: { x: 600, y: 200 }, grabbable: false  },
                                    { data: { id: 'demand', name: 'Demanda de Adopcion' }, position: { x: 600, y: 350 }, grabbable: false  },
                                    { data: { id: 'ab2', name: 'Area Juridica' }, position: { x: 800, y: 200 }, grabbable: false  },
                                    { data: { id: 'inf', name: 'Infante' }, position: { x: 1000, y: 50 }, grabbable: false  },
                                    { data: { id: 'ts3', name: 'Trabajadora Social' }, position: { x: 1000, y: 200 }, grabbable: false  },
                                    { data: { id: 'ab3', name: 'Abogado' }, position: { x: 1200, y: 200 }, grabbable: false  }
                                ],
                                edges: [
                                    { data: { id: 'secre_cor', source: 'secre', target: 'cor' }},
                                    { data: { id: 'cor_ts', source: 'cor', target: 'ts' }},
                                    { data: { id: 'cor_ps', source: 'cor', target: 'ps' }},
                                    { data: { id: 'cor_doc', source: 'cor', target: 'doc' }},
                                    { data: { id: 'cert_cor2', source: 'cert', target: 'cor2' }},
                                    { data: { id: 'ts_cor2', source: 'ts', target: 'cor2' }},
                                    { data: { id: 'ps_cor2', source: 'ps', target: 'cor2' }},
                                    { data: { id: 'doc_cor2', source: 'doc', target: 'cor2' }},
                                    { data: { id: 'demand_cor2', source: 'demand', target: 'cor2' }},
                                    { data: { id: 'cor2_ab2', source: 'cor2', target: 'ab2' }},
                                    { data: { id: 'inf_ts3', source: 'inf', target: 'ts3' }},
                                    { data: { id: 'ab2_ts3', source: 'ab2', target: 'ts3' }},
                                    { data: { id: 'ts3_ab3', source: 'ts3', target: 'ab3' }}
                                ]
                            },

                            layout: {
                                name: 'preset'
                            },
                            userZoomingEnabled: false,
                            userPanningEnabled: false,
                            grabbable: false
                        });
                        cy.$('node').on('click', function(e){
                            var ele = e.target;
                            if(ele.id() === 'ts'){
                                $('#modalTrabajoSocial').modal('show');
                            }else if(ele.id() === 'ps'){
                                $('#modalPsicologo').modal('show');
                            }else if(ele.id() === 'doc'){
                                $('#modalDoctor').modal('show');
                            }
                        });

                        var edges_done = @json($edges_done);
                        var j = 0;
                        var animatedWorlflow = function(){
                            if( j < edges_done.length ){
                                cy.$(edges_done[j]).addClass('highlighted');
                                j++;
                                setTimeout(animatedWorlflow, 200);
                            }
                        };
                        animatedWorlflow();
                    </script>

                    @if (in_array($solicitud['estado'], array(0, 1)))
                        @include('solicitud.include.requisitos_display')
                    @endif

                    @include('solicitud.include.modals')
                    {{--@if (Auth::user()->rol == 'Secretaria')--}}
                        {{--@if (in_array($solicitud['estado'], array(0)))--}}
                            {{--@include('solicitud.include.requisitos_display')--}}
                            {{--@include('solicitud.include.requisitos')--}}
                        {{--@endif--}}
                    {{--@endif--}}
                    {{--@if (Auth::user()->rol == 'Coordinador')--}}
                        {{--@if (in_array($solicitud['estado'], array(1)))--}}
                            {{--@include('solicitud.include.requisitos_display')--}}
                            {{--@include('solicitud.include.verificacion')--}}
                        {{--@elseif(in_array($solicitud['estado'], array(3)))--}}
                            {{--@include('solicitud.include.cert_idoneidad')--}}
                        {{--@endif--}}
                    {{--@endif--}}
                    {{--@if (Auth::user()->rol == 'Trabajador Social')--}}
                        {{--@if (in_array($solicitud['estado'], array(2)))--}}
                            {{--@include('solicitud.include.valoracion_ts')--}}
                        {{--@elseif(in_array($solicitud['estado'], array(3)))--}}
                            {{--@include('solicitud.include.cert_taller')--}}
                        {{--@elseif(in_array($solicitud['estado'], array(6)))--}}
                            {{--@include('solicitud.include.asignacion_infante')--}}
                        {{--@elseif(in_array($solicitud['estado'], array(7)))--}}
                            {{--@include('solicitud.include.informe_social')--}}
                        {{--@endif--}}
                    {{--@endif--}}
                    {{--@if (Auth::user()->rol == 'Psicologo')--}}
                        {{--@if (in_array($solicitud['estado'], array(2)))--}}
                            {{--@include('solicitud.include.valoracion_ps')--}}
                        {{--@endif--}}
                    {{--@endif--}}
                    {{--@if (Auth::user()->rol == 'Doctor')--}}
                        {{--@if (in_array($solicitud['estado'], array(2)))--}}
                            {{--@include('solicitud.include.valoracion_doc')--}}
                        {{--@endif--}}
                    {{--@endif--}}
                    {{--@if (Auth::user()->rol == 'Abogado')--}}
                        {{--@if(!$solicitud['demanda_adopcion'])--}}
                            {{--@include('solicitud.include.demanda')--}}
                        {{--@endif--}}
                        {{--@if (in_array($solicitud['estado'], array(4)))--}}
                            {{--@include('solicitud.include.representacion')--}}
                        {{--@elseif(in_array($solicitud['estado'], array(5)))--}}
                            {{--<button type="submit" class="btn btn-primary btn-block">--}}
                                {{--Dispocision de Asignacion Recibida--}}
                            {{--</button>--}}
                        {{--@elseif(in_array($solicitud['estado'], array(8)))--}}
                            {{--<button type="submit" class="btn btn-primary btn-block">--}}
                                {{--Enviar Informe Psicosocial--}}
                            {{--</button>--}}
                        {{--@endif--}}
                    {{--@endif--}}
                    @if (!in_array($solicitud['estado'], array(0, 1)))
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm" width="100%" cellspacing="0">
                                <thead>
                                <tr>
                                    <th>Valoracion</th>
                                    <th>Responable</th>
                                    <th class="text-center">Fecha de la Valoracion</th>
                                    <th class="text-center">Estado</th>
                                    <th class="text-center">Accion</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>Valoracion Social</td>
                                    <td>{{ $solicitud['trabajador_social']['nombres'] }} {{ $solicitud['trabajador_social']['apellido_paterno'] }} {{ $solicitud['trabajador_social']['apellido_materno'] }}</td>
                                    @if(is_null($solicitud['valoracion_trabajador_social_id']))
                                        <td class="text-center">Sin Fecha Asignada</td>
                                        <td class="text-center">-</td>
                                        <td class="text-center">-</td>
                                    @else
                                        <td class="text-center">{{ $solicitud['valoracion_trabajador_social']['fecha_valoracion']->format('d \d\e F \d\e\l Y') }}</td>
                                        <td class="text-center">{{ $solicitud['valoracion_trabajador_social']['estado'] ? "Valorado" : "Por Valorar" }}</td>
                                        <td class="text-center">
                                            @if($solicitud['valoracion_trabajador_social']['estado'] == 1)
                                                <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Mostrar">
                                                    <i class="fa fa-commenting-o text-primary" data-toggle="modal" data-target="#modalTrabajoSocial"></i>
                                                </span>
                                            @else
                                                -
                                            @endif
                                        </td>
                                    @endif
                                </tr>
                                <tr>
                                    <td>Valoracion Psicologica</td>
                                    <td>{{ $solicitud['psicologo']['nombres'] }} {{ $solicitud['psicologo']['apellido_paterno'] }} {{ $solicitud['psicologo']['apellido_materno'] }}</td>
                                    @if(is_null($solicitud['valoracion_psicologo_id']))
                                        <td class="text-center">Sin Fecha Asignada</td>
                                        <td class="text-center">-</td>
                                        <td class="text-center">-</td>
                                    @else
                                        <td class="text-center">{{ $solicitud['valoracion_psicologo']['fecha_valoracion']->format('d \d\e F \d\e\l Y') }}</td>
                                        <td class="text-center">{{ $solicitud['valoracion_psicologo']['estado'] ? "Valorado" : "Por Valorar" }}</td>
                                        <td class="text-center">
                                            @if($solicitud['valoracion_psicologo']['estado'] == 1)
                                                <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Mostrar">
                                                        <i class="fa fa-commenting-o text-primary" data-toggle="modal" data-target="#modalPsicologo"></i>
                                                    </span>
                                            @else
                                                -
                                            @endif
                                        </td>
                                    @endif
                                </tr>
                                <tr>
                                    <td>Valoracion Medica</td>
                                    <td>{{ $solicitud['doctor']['nombres'] }} {{ $solicitud['doctor']['apellido_paterno'] }} {{ $solicitud['doctor']['apellido_materno'] }}</td>
                                    @if(is_null($solicitud['valoracion_doctor_id']))
                                        <td class="text-center">Sin Fecha Asignada</td>
                                        <td class="text-center">-</td>
                                        <td class="text-center">-</td>
                                    @else
                                        <td class="text-center">{{ $solicitud['valoracion_doctor']['fecha_valoracion']->format('d \d\e F \d\e\l Y') }}</td>
                                        <td class="text-center">{{ $solicitud['valoracion_doctor']['estado'] ? "Valorado" : "Por Valorar" }}</td>
                                        <td class="text-center">
                                            @if($solicitud['valoracion_doctor']['estado'] == 1)
                                                <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Mostrar">
                                                        <i class="fa fa-commenting-o text-primary" data-toggle="modal" data-target="#modalDoctor"></i>
                                                    </span>
                                            @else
                                                -
                                            @endif
                                        </td>
                                    @endif
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    @endif
                    @if($documents->count() > 0)
                        <h6>Documentos de la Solicitud
                            <span class="pull-right">
                                Acciones
                            </span>
                        </h6>
                        <div id="accordion2">
                            @foreach($DocumentsTypes as $DocumentsType)
                                <div id="heading{{ key($DocumentsTypes) }}">
                                <span class="list-group-item text-uppercase collapsed" style="padding: .5rem 1.25rem;font-size: 14px;"
                                      data-toggle="collapse"
                                      data-target="#collapse{{ key($DocumentsTypes) }}"
                                      aria-expanded="false"
                                      aria-controls="collapse{{ key($DocumentsTypes) }}">
                                    <strong>{{ key($DocumentsTypes) }} ({{count(array_intersect(array_keys($DocumentsType), array_map(function ($ar) {return $ar['type'];}, $documents->toArray())))}})</strong>
                                </span>
                                </div>
                                <div id="collapse{{ key($DocumentsTypes) }}" class="collapse" aria-labelledby="heading{{ key($DocumentsTypes) }}" data-parent="#accordion2">
                                    <ul class="list-group list-group-flush">
                                        @foreach($documents as $document)
                                            @if($DocumentsType[$document['type']])
                                                <li class="list-group-item text-primary" style="padding: .10rem 0rem .10rem 2rem;font-size: 14px;"><strong>{{$DocumentsType[$document['type']]}}</strong> {{$document['name']}}
                                                    <span class="pull-right">
                                                    @if(in_array($document['mime'], array("image/png", "application/pdf", "image/jpeg")))
                                                            <a class="btn btn-primary btn-sm" target="_blank" href="{{ url('/document') }}/{{$document['id']}}" data-toggle="tooltip" data-placement="left" title="Ver"><i class="fa fa-eye"></i></a>
                                                        @endif
                                                        <a class="btn btn-success btn-sm" href="{{ url('/document/download') }}/{{$document['id']}}" data-toggle="tooltip" data-placement="left" title="Descargar"><i class="fa fa-download"></i></a>
                                                </span>
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </div>
                                <?php next($DocumentsTypes); ?>
                            @endforeach
                        </div>
                    @endif
                </form>
            </div>
        </div>
    </div>
@endsection


