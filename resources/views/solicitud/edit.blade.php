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
                                    'width': 80,
                                    'height': 80
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
                                    'background-color': '#33ce33',
                                    'line-color': '#33ce33',
                                    'target-arrow-color': '#33ce33',
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
                                .selector('#demand, #cert')
                                .css({
                                    'background-width': '80%',
                                    'background-height': '80%'
                                })
                                .selector('.edge_done').css({'line-color': "green", 'target-arrow-color': "green"})
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
                                    { data: { source: 'secre', target: 'cor' }, classes:@if($edges_done['requisitos']) "edge_done" @else "" @endif },
                                    { data: { source: 'cor', target: 'ts' }, classes:@if($edges_done['verificado']) "edge_done" @else "" @endif },
                                    { data: { source: 'cor', target: 'ps' }, classes:@if($edges_done['verificado']) "edge_done" @else "" @endif },
                                    { data: { source: 'cor', target: 'doc' }, classes:@if($edges_done['verificado']) "edge_done" @else "" @endif },
                                    { data: { source: 'cert', target: 'cor2' }, classes:@if($edges_done['certificado']) "edge_done" @else "" @endif },
                                    { data: { source: 'ts', target: 'cor2' }, classes:@if($edges_done['val_social']) "edge_done" @else "" @endif },
                                    { data: { source: 'ps', target: 'cor2' }, classes:@if($edges_done['val_psicologica']) "edge_done" @else "" @endif },
                                    { data: { source: 'doc', target: 'cor2' }, classes:@if($edges_done['val_medica']) "edge_done" @else "" @endif },
                                    { data: { source: 'demand', target: 'cor2' }, classes:@if($edges_done['demanda']) "edge_done" @else "" @endif },
                                    { data: { source: 'cor2', target: 'ab2' }, classes:@if($edges_done['area_juridica']) "edge_done" @else "" @endif },
                                    { data: { source: 'inf', target: 'ts3' }, classes:@if($edges_done['acercamiento']) "edge_done" @else "" @endif },
                                    { data: { source: 'ab2', target: 'ts3' }, classes:@if($edges_done['asignacion']) "edge_done" @else "" @endif },
                                    { data: { source: 'ts3', target: 'ab3' }, classes:@if($edges_done['finalizado']) "edge_done" @else "" @endif }
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
                            // console.log('clicked ' + ele.id());
                        });

                        // cy.getElementById('secre').onclick = function() {myFunction()};
                        // document.getElementById("secre").onclick = function() {myFunction()};
                        // document.getElementById("cy").onclick = function() {myFunction()};

                        function myFunction() {
                            $('#modalTrabajoSocial').modal('show');
                        }

                    </script>
                    @if (in_array($solicitud['estado'], array(0, 1))  and in_array(Auth::user()->rol, array('Coordinador', 'Secretaria')))
                        @foreach($DocumentsTypes['requisitos'] as $item)
                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col-md-5"></div>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="requisitos" disabled @if (in_array(array_search($item, $DocumentsTypes['requisitos']), $DocumentsTypesStored)) checked @endif>
                                        <label class="custom-control-label" for="requisitos">{{ $item }}</label>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
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
                                                @endif
                                            </td>
                                        @endif
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        @if(!is_null($solicitud['valoracion_trabajador_social_id']) and $solicitud['valoracion_trabajador_social']['estado'] == 1)
                            <div class="modal fade" id="modalTrabajoSocial" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Valoracion Social</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-md-10 offset-md-1">
                                                    <div class="row">
                                                        <span class="col-sm-auto font-weight-bold">Fecha de la Valoracion:</span>
                                                        <span class="col-sm-auto">{{ $solicitud['valoracion_trabajador_social']['fecha_valoracion']->format('d \d\e F \d\e\l Y')  }}</span>
                                                    </div>
                                                    <div class="row">
                                                        <span class="col-sm-auto font-weight-bold">Condiciones de Vivienda:</span>
                                                        <span class="col-sm-auto font-weight-bold {{$solicitud['valoracion_trabajador_social']['condiciones_vivienda'] ? 'text-success' : 'text-danger'}}">{{$solicitud['valoracion_trabajador_social']['condiciones_vivienda'] == true ? "Favorable" : "Desfavorable" }}</span>
                                                    </div>
                                                    <div class="row">
                                                        <span class="col-sm-auto font-weight-bold">Estructura Familiar:</span>
                                                        <span class="col-sm-auto font-weight-bold {{$solicitud['valoracion_trabajador_social']['estructura_familiar'] ? 'text-success' : 'text-danger'}}">{{$solicitud['valoracion_trabajador_social']['estructura_familiar'] == true ? "Favorable" : "Desfavorable" }}</span>
                                                    </div>
                                                    <div class="row">
                                                        <span class="col-sm-auto font-weight-bold">Situacion Actual:</span>
                                                        <span class="col-sm-auto font-weight-bold {{$solicitud['valoracion_trabajador_social']['situacion_actual'] ? 'text-success' : 'text-danger'}}">{{$solicitud['valoracion_trabajador_social']['situacion_actual'] == true ? "Favorable" : "Desfavorable" }}</span>
                                                    </div>
                                                    <div class="row">
                                                        <span class="col-sm-12 font-weight-bold">Observacion:</span>
                                                        <p class="col-sm-12 text-justify">{{ $solicitud['valoracion_trabajador_social']['observacion_trabajador_social'] }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if(!is_null($solicitud['valoracion_psicologo_id']) and $solicitud['valoracion_psicologo']['estado'] == 1)
                            <div class="modal fade" id="modalPsicologo" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Valoracion Psicologica</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-md-10 offset-md-1">
                                                    <div class="row">
                                                        <span class="col-sm-auto font-weight-bold">Fecha de la Valoracion:</span>
                                                        <span class="col-sm-auto">{{ $solicitud['valoracion_psicologo']['fecha_valoracion']->format('d \d\e F \d\e\l Y')  }}</span>
                                                    </div>
                                                    <div class="row">
                                                        <span class="col-sm-auto font-weight-bold">Evaluacion Psicologica:</span>
                                                        <span class="col-sm-auto font-weight-bold {{$solicitud['valoracion_psicologo']['evaluacion_psicologica'] ? 'text-success' : 'text-danger'}}">{{$solicitud['valoracion_psicologo']['evaluacion_psicologica'] == true ? "Favorable" : "Desfavorable" }}</span>
                                                    </div>
                                                    <div class="row">
                                                        <span class="col-sm-auto font-weight-bold">Dinamica Familiar:</span>
                                                        <span class="col-sm-auto font-weight-bold {{$solicitud['valoracion_psicologo']['dinamica_familiar'] ? 'text-success' : 'text-danger'}}">{{$solicitud['valoracion_psicologo']['dinamica_familiar'] == true ? "Favorable" : "Desfavorable" }}</span>
                                                    </div>
                                                    <div class="row">
                                                        <span class="col-sm-auto font-weight-bold">Motivacion para Adopcion:</span>
                                                        <span class="col-sm-auto font-weight-bold {{$solicitud['valoracion_psicologo']['motivacion_adopcion'] ? 'text-success' : 'text-danger'}}">{{$solicitud['valoracion_psicologo']['motivacion_adopcion'] == true ? "Favorable" : "Desfavorable" }}</span>
                                                    </div>
                                                    <div class="row">
                                                        <span class="col-sm-12 font-weight-bold">Observacion:</span>
                                                        <p class="col-sm-12 text-justify">{{ $solicitud['valoracion_psicologo']['observacion_psicologo'] }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if(!is_null($solicitud['valoracion_doctor_id']) and $solicitud['valoracion_doctor']['estado'] == 1)
                            <div class="modal fade" id="modalDoctor" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Valoracion Medica</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-md-10 offset-md-1">
                                                    <div class="row">
                                                        <span class="col-sm-auto font-weight-bold">Fecha de la Valoracion:</span>
                                                        <span class="col-sm-auto">{{ $solicitud['valoracion_doctor']['fecha_valoracion']->format('d \d\e F \d\e\l Y')  }}</span>
                                                    </div>
                                                    <div class="row">
                                                        <span class="col-sm-auto font-weight-bold">Condicion Medica:</span>
                                                        <span class="col-sm-auto font-weight-bold {{$solicitud['valoracion_doctor']['condicion_medica'] ? 'text-success' : 'text-danger'}}">{{$solicitud['valoracion_doctor']['condicion_medica'] == true ? "Favorable" : "Desfavorable" }}</span>
                                                    </div>
                                                    <div class="row">
                                                        <span class="col-sm-12 font-weight-bold">Observacion:</span>
                                                        <p class="col-sm-12 text-justify">{{ $solicitud['valoracion_doctor']['observacion_doctor'] }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endif
                    @if (in_array($solicitud['estado'], array(2)) and in_array(Auth::user()->rol, array('Trabajador Social', 'Psicologo', 'Doctor')))
                        @if (Auth::user()->rol == 'Trabajador Social' and !is_null($solicitud['valoracion_trabajador_social_id']))
                            @if ($solicitud['valoracion_trabajador_social']['fecha_valoracion'] <= date('Y-m-d h:m:s') and $solicitud['valoracion_trabajador_social']['estado'] == 0)
                                <div class="form-group">
                                    <div class="form-row">
                                        <div class="col-sm-8 offset-sm-2 col-lg-4 offset-lg-4 text-center">
                                            <div class="row">
                                                <label for="condiciones_vivienda" class="col-sm-7 text-right mt-auto">Condiciones de Vivienda</label>
                                                <div class="col-sm-5">
                                                    <input type="checkbox" name="condiciones_vivienda" checked data-toggle="toggle" data-on="Favorable" data-off="Desfavorable" data-onstyle="success" data-offstyle="danger" style="display: none;">
                                                </div>
                                            </div>
                                            <div class="row mt-1">
                                                <label for="estructura_familiar" class="col-sm-7 text-right mt-auto">Estructura Familiar</label>
                                                <div class="col-sm-5">
                                                    <input type="checkbox" name="estructura_familiar" checked data-toggle="toggle" data-on="Favorable" data-off="Desfavorable" data-onstyle="success" data-offstyle="danger" style="display: none;">
                                                </div>
                                            </div>
                                            <div class="row mt-1">
                                                <label for="situacion_actual" class="col-sm-7 text-right mt-auto">Situacion Actual</label>
                                                <div class="col-sm-5">
                                                    <input type="checkbox" name="situacion_actual" checked data-toggle="toggle" data-on="Favorable" data-off="Desfavorable" data-onstyle="success" data-offstyle="danger" style="display: none;">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mt-2{{ $errors->has('doc_file') ? ' mb-0' : '' }}">
                                    <div class="form-row">
                                        <div class="col-md-4">
                                            <label for="doc_type">Documento</label>
                                            <select class="form-control" name="doc_type" readonly>
                                                <option value="101">Informe Social</option>
                                            </select>
                                        </div>
                                        <div class="col-md-8{{ $errors->has('doc_file') ? ' has-error' : '' }}">
                                            <label for="doc_file">Archivo</label>
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input cursor-pointer" id="doc_file" name="doc_file" lang="es">
                                                <label class="custom-file-label" for="doc_file">Seleccionar Archivo</label>
                                            </div>
                                            @if ($errors->has('doc_file'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('doc_file') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group{{ $errors->has('observacion_trabajador_social') ? ' has-error' : '' }}">
                                    <label for="observacion_trabajador_social">Observacion</label>
                                    <textarea class="form-control" id="observacion_trabajador_social" name="observacion_trabajador_social" rows="3" placeholder="Observaciones de la Valoracion Social.">@if(old('observacion_trabajador_social')) {{ old('observacion_trabajador_social') }} @else{{ $solicitud['observacion_trabajador_social'] }}@endif</textarea>
                                    @if ($errors->has('observacion_trabajador_social'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('observacion_trabajador_social') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <button type="submit" class="btn btn-primary btn-block">
                                    Registrar Valoracion
                                </button>
                            @endif
                        @elseif (Auth::user()->rol == 'Psicologo' and !is_null($solicitud['valoracion_psicologo_id']))
                            @if ($solicitud['valoracion_psicologo']['fecha_valoracion'] <= date('Y-m-d h:m:s') and $solicitud['valoracion_psicologo']['estado'] == 0)
                                <div class="form-group">
                                    <div class="form-row">
                                        <div class="col-sm-8 offset-sm-2 col-lg-4 offset-lg-4 text-center">
                                            <div class="row">
                                                <label for="evaluacion_psicologica" class="col-sm-7 text-right mt-auto">Evaluacion Psicologica</label>
                                                <div class="col-sm-5">
                                                    <input type="checkbox" name="evaluacion_psicologica" checked data-toggle="toggle" data-on="Favorable" data-off="Desfavorable" data-onstyle="success" data-offstyle="danger" style="display: none;">
                                                </div>
                                            </div>
                                            <div class="row mt-1">
                                                <label for="dinamica_familiar" class="col-sm-7 text-right mt-auto">Dinamica Familiar</label>
                                                <div class="col-sm-5">
                                                    <input type="checkbox" name="dinamica_familiar" checked data-toggle="toggle" data-on="Favorable" data-off="Desfavorable" data-onstyle="success" data-offstyle="danger" style="display: none;">
                                                </div>
                                            </div>
                                            <div class="row mt-1">
                                                <label for="motivacion_adopcion" class="col-sm-7 text-right mt-auto">Motivacion para Adopcion</label>
                                                <div class="col-sm-5">
                                                    <input type="checkbox" name="motivacion_adopcion" checked data-toggle="toggle" data-on="Favorable" data-off="Desfavorable" data-onstyle="success" data-offstyle="danger" style="display: none;">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mt-2{{ $errors->has('doc_file') ? ' mb-0' : '' }}">
                                    <div class="form-row">
                                        <div class="col-md-4">
                                            <label for="doc_type">Documento</label>
                                            <select class="form-control" name="doc_type" readonly>
                                                <option value="102">Informe Psicologico</option>
                                            </select>
                                        </div>
                                        <div class="col-md-8{{ $errors->has('doc_file') ? ' has-error' : '' }}">
                                            <label for="doc_file">Archivo</label>
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input cursor-pointer" id="doc_file" name="doc_file" lang="es">
                                                <label class="custom-file-label" for="doc_file">Seleccionar Archivo</label>
                                            </div>
                                            @if ($errors->has('doc_file'))
                                                <span class="help-block">
                                            <strong>{{ $errors->first('doc_file') }}</strong>
                                        </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group{{ $errors->has('observacion_psicologo') ? ' has-error' : '' }}">
                                    <label for="observacion_psicologo">Observacion</label>
                                    <textarea class="form-control" id="observacion_psicologo" name="observacion_psicologo" rows="3" placeholder="Observaciones de la Valoracion Psicologica.">@if(old('observacion_psicologo')) {{ old('observacion_psicologo') }} @else{{ $solicitud['observacion_psicologo'] }}@endif</textarea>
                                    @if ($errors->has('observacion_psicologo'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('observacion_psicologo') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <button type="submit" class="btn btn-primary btn-block">
                                    Registrar Valoracion
                                </button>
                            @endif
                        @elseif (Auth::user()->rol == 'Doctor' and !is_null($solicitud['valoracion_doctor_id']))
                            @if ($solicitud['valoracion_doctor']['fecha_valoracion'] <= date('Y-m-d h:m:s') and $solicitud['valoracion_doctor']['estado'] == 0)
                                <div class="form-group">
                                    <div class="form-row">
                                        <div class="col-sm-8 offset-sm-2 col-lg-4 offset-lg-4 text-center">
                                            <label for="condicion_medica" class="mr-3">Condicion Medica</label>
                                            <input type="checkbox" class="d-none" checked id="condicion_medica" name="condicion_medica" data-toggle="toggle" data-on="Favorable" data-off="Desfavorable" data-onstyle="success" data-offstyle="danger">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mt-2{{ $errors->has('doc_file') ? ' mb-0' : '' }}">
                                    <div class="form-row">
                                        <div class="col-md-4">
                                            <label for="doc_type">Documento</label>
                                            <select class="form-control" name="doc_type" readonly>
                                                <option value="103">Certificado Medico</option>
                                            </select>
                                        </div>
                                        <div class="col-md-8{{ $errors->has('doc_file') ? ' has-error' : '' }}">
                                            <label for="doc_file">Archivo</label>
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input cursor-pointer" id="doc_file" name="doc_file" lang="es">
                                                <label class="custom-file-label" for="doc_file">Seleccionar Archivo</label>
                                            </div>
                                            @if ($errors->has('doc_file'))
                                                <span class="help-block">
                                                <strong>{{ $errors->first('doc_file') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group{{ $errors->has('observacion_doctor') ? ' has-error' : '' }}">
                                    <label for="observacion_doctor">Observacion</label>
                                    <textarea class="form-control" id="observacion_doctor" name="observacion_doctor" rows="3" placeholder="Observaciones de la Valoracion Medica.">@if(old('observacion_doctor')) {{ old('observacion_doctor') }} @else{{ $solicitud['observacion_doctor'] }}@endif</textarea>
                                    @if ($errors->has('observacion_doctor'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('observacion_doctor') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <button type="submit" class="btn btn-primary btn-block">
                                    Registrar Valoracion
                                </button>
                            @endif
                        @else
                            <div class="row">
                                <div class="col-md-4 offset-md-4">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Fecha de Valoracion</label>
                                        <input type="date" class="form-control text-right" id="fecha_valoracion" name="fecha_valoracion" aria-describedby="fecha_valoracionHelp" placeholder="Ingrese la fecha de valoracion">
                                        <small id="fecha_valoracionHelp" class="form-text text-muted">Fecha en la que sera realizada la valoracion respectiva.</small>
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-block mb-2">Confirmar Fecha</button>
                                </div>
                            </div>
                        @endif
                    @endif
                    @if (in_array($solicitud['estado'], array(3)) and in_array(Auth::user()->rol, array('Trabajador Social')) and !in_array(202, $DocumentsTypesStored))
                        <div class="form-group mt-2{{ $errors->has('doc_file') ? ' mb-0' : '' }}">
                            <div class="form-row">
                                <div class="col-md-4">
                                    <label for="doc_type">Documento</label>
                                    <select class="form-control" name="doc_type" readonly>
                                        <option value="202">Taller de Preparacion</option>
                                    </select>
                                </div>
                                <div class="col-md-8{{ $errors->has('doc_file') ? ' has-error' : '' }}">
                                    <label for="doc_file">Archivo</label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input cursor-pointer" id="doc_file" name="doc_file" lang="es">
                                        <label class="custom-file-label" for="doc_file">Seleccionar Archivo</label>
                                    </div>
                                    @if ($errors->has('doc_file'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('doc_file') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">
                            Adjuntar Certificado de Taller de Preparacion
                        </button>
                    @endif
                    @if (in_array($solicitud['estado'], array(3)) and in_array(Auth::user()->rol, array('Coordinador')))
                        @if (in_array(202, $DocumentsTypesStored) and $solicitud['demanda_adopcion'])
                            @if (!in_array(201, $DocumentsTypesStored))
                                <div class="form-group mt-2{{ $errors->has('doc_file') ? ' mb-0' : '' }}">
                                    <div class="form-row">
                                        <div class="col-md-4">
                                            <label for="doc_type">Documento</label>
                                            <select class="form-control" name="doc_type" readonly>
                                                <option value="201">Certificado de Idoneidad</option>
                                            </select>
                                        </div>
                                        <div class="col-md-8{{ $errors->has('doc_file') ? ' has-error' : '' }}">
                                            <label for="doc_file">Archivo</label>
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input cursor-pointer" id="doc_file" name="doc_file" lang="es">
                                                <label class="custom-file-label" for="doc_file">Seleccionar Archivo</label>
                                            </div>
                                            @if ($errors->has('doc_file'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('doc_file') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endif
                            <div class="form-group{{ $errors->has('observacion_documentos') ? ' has-error' : '' }}">
                                <label for="observacion_documentos">Observacion</label>
                                <textarea class="form-control" id="observacion_documentos" name="observacion_documentos" rows="3" placeholder="Observaciones de la Revision de Documentos.">@if(old('observacion_documentos')) {{ old('observacion_documentos') }} @else{{ $solicitud['observacion_documentos'] }}@endif</textarea>
                                @if ($errors->has('observacion_documentos'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('observacion_documentos') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">
                                Enviar Documentos a Area Juridica
                            </button>
                        @elseif(!in_array(202, $DocumentsTypesStored))
                            <h6 class="text-center text-danger">Sin Certificado de Taller de Preparacion a Madres y Padres en Proceso de Adopcion</h6>
                        @endif
                    @endif
                    @if (in_array($solicitud['estado'], array(4)) and in_array(Auth::user()->rol, array('Abogado')))
                        <div class="form-group{{ $errors->has('observacion_representacion') ? ' has-error' : '' }}">
                            <label for="observacion_representacion">Observacion</label>
                            <textarea class="form-control" id="observacion_representacion" name="observacion_representacion" rows="3" placeholder="Observaciones de la Representacion.">@if(old('observacion_representacion')) {{ old('observacion_representacion') }} @else{{ $solicitud['observacion_representacion'] }}@endif</textarea>
                            @if ($errors->has('observacion_representacion'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('observacion_representacion') }}</strong>
                                </span>
                            @endif
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">
                            Iniciar Representacion
                        </button>
                    @endif
                    @if (in_array($solicitud['estado'], array(5)) and in_array(Auth::user()->rol, array('Abogado')))
                        <button type="submit" class="btn btn-primary btn-block">
                            Dispocision de Asignacion Recibida
                        </button>
                    @endif
                    @if (in_array($solicitud['estado'], array(6)) and in_array(Auth::user()->rol, array('Trabajador Social')))
                        <div class="form-group">
                            <div class="form-row">
                                <div class="col-md-6{{ $errors->has('infante') ? ' has-error' : '' }} {{ $errors->has('infante_id') ? ' has-error' : '' }}">
                                    <label for="infante">Infante</label>
                                    <input id="infante_search" name="infante" class="form-control" type="text" placeholder="Ingrese el CI del infante" value="{{ old('infante') }}">
                                    @if ($errors->has('infante'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('infante') }}</strong>
                                        </span>
                                    @endif
                                    @if ($errors->has('infante_id'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('infante_id') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <input type="hidden" name="infante_id" id="infante_id" value="{{ old('infante_id') }}">
                                <div class="col-md-3{{ $errors->has('infante_age') ? ' has-error' : '' }}">
                                    <label for="infante_age">Edad</label>
                                    <input id="infante_age" name="infante_age" class="form-control" type="text" placeholder="-" value="{{ old('infante_age') }}" readonly>
                                </div>
                                <div class="col-md-3{{ $errors->has('infante_centro') ? ' has-error' : '' }}">
                                    <label for="infante_centro">Centro</label>
                                    <input id="infante_centro" name="infante_centro" class="form-control" type="text" placeholder="-" value="{{ old('infante_centro') }}" readonly>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">
                            Asignar Niño
                        </button>
                    @endif
                    @if (in_array($solicitud['estado'], array(7)) and in_array(Auth::user()->rol, array('Trabajador Social')))
                        <div class="form-group">
                            <div class="form-row">
                                <div class="col-sm-8 offset-sm-2 col-lg-4 offset-lg-4 text-center">
                                    <label for="informe_psicosocial" class="mr-3">Resultado del Informe</label>
                                    <input type="checkbox" class="d-none" checked id="informe_psicosocial" name="informe_psicosocial" data-toggle="toggle" data-on="Favorable" data-off="Desfavorable" data-onstyle="success" data-offstyle="danger">
                                </div>
                            </div>
                        </div>
                        <div class="form-group mt-2{{ $errors->has('doc_file') ? ' mb-0' : '' }}">
                            <div class="form-row">
                                <div class="col-md-4">
                                    <label for="doc_type">Documento</label>
                                    <select class="form-control" name="doc_type" readonly>
                                        <option value="203">Informe Psicosocial</option>
                                    </select>
                                </div>
                                <div class="col-md-8{{ $errors->has('doc_file') ? ' has-error' : '' }}">
                                    <label for="doc_file">Archivo</label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input cursor-pointer" id="doc_file" name="doc_file" lang="es">
                                        <label class="custom-file-label" for="doc_file">Seleccionar Archivo</label>
                                    </div>
                                    @if ($errors->has('doc_file'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('doc_file') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('observacion_informe_psiosocial') ? ' has-error' : '' }}">
                            <label for="observacion_informe_psiosocial">Observacion</label>
                            <textarea class="form-control" id="observacion_informe_psiosocial" name="observacion_informe_psiosocial" rows="3" placeholder="Observaciones del Informe Psicosocial.">@if(old('observacion_informe_psiosocial')) {{ old('observacion_informe_psiosocial') }} @else{{ $solicitud['observacion_informe_psiosocial'] }}@endif</textarea>
                            @if ($errors->has('observacion_informe_psiosocial'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('observacion_informe_psiosocial') }}</strong>
                                </span>
                            @endif
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">
                            Subir Informe Psicosocial
                        </button>
                    @endif
                    @if (in_array($solicitud['estado'], array(8)) and in_array(Auth::user()->rol, array('Abogado')))
                        <button type="submit" class="btn btn-primary btn-block">
                            Enviar Informe Psicosocial
                        </button>
                    @endif
                    @if(in_array(Auth::user()->rol, array('Abogado')) and !$solicitud['demanda_adopcion'])
                        <div class="form-group{{ $errors->has('observacion_demanda') ? ' has-error' : '' }}">
                            <label for="observacion_demanda">Observacion</label>
                            <textarea class="form-control" id="observacion_demanda" name="observacion_demanda" rows="3" placeholder="Observaciones de la Demanada.">@if(old('observacion_demanda')) {{ old('observacion_demanda') }} @else{{ $solicitud['observacion_demanda'] }}@endif</textarea>
                            @if ($errors->has('observacion_demanda'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('observacion_demanda') }}</strong>
                                </span>
                            @endif
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">
                            Demanda de Adopcion Recibida
                        </button>
                    @endif
                    @if($documents->count() > 0)
                        <div class="mt-3">
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
                                        <strong>{{ key($DocumentsTypes) }}</strong>
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
                        </div>
                    @endif
                    @if ($solicitud['estado'] == 0 and in_array(Auth::user()->rol, array('Secretaria')))
                        @if(count($DocumentsTypes['requisitos']) != count($DocumentsTypesStored))
                            <div class="form-group mt-2">
                                <div class="form-row">
                                    <div class="col-md-4{{ $errors->has('doc_type') ? ' has-error' : '' }}">
                                        <label for="doc_type">Documento</label>
                                        <select class="form-control" name="doc_type">
                                            @while($item = current($DocumentsTypes['requisitos']))
                                                @if (!in_array(key($DocumentsTypes['requisitos']), $DocumentsTypesStored))
                                                    <option value="{{key($DocumentsTypes['requisitos'])}}" @if(old('doc_type') == key($DocumentsTypes['requisitos'])) selected @endif>{{ $item }}</option>
                                                @endif
                                                <?php next($DocumentsTypes['requisitos']) ?>
                                            @endwhile
                                        </select>
                                    </div>
                                    <div class="col-md-8{{ $errors->has('doc_file') ? ' has-error' : '' }}">
                                        <label for="doc_file">Archivo</label>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="doc_file" name="doc_file" lang="es">
                                            <label class="custom-file-label" for="doc_file">Seleccionar Archivo</label>
                                        </div>
                                        @if ($errors->has('doc_file'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('doc_file') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif
                        <div class="form-group mt-3{{ $errors->has('observacion_registro') ? ' has-error' : '' }}">
                            <label for="observacion_registro">Observacion</label>
                            <textarea class="form-control" id="observacion_registro" name="observacion_registro" rows="3" placeholder="Observaciones de la Solicitud de Adopcion.">@if(old('observacion_registro')) {{ old('observacion_registro') }} @else {{ $solicitud['observacion_registro'] }} @endif</textarea>
                            @if ($errors->has('observacion_registro'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('observacion_registro') }}</strong>
                                </span>
                            @endif
                        </div>
                        @if(count($DocumentsTypes['requisitos']) != count($DocumentsTypesStored))
                            <button type="submit" class="btn btn-primary btn-block">
                                Actualizar Solicitud
                            </button>
                        @else
                            <button type="submit" class="btn btn-success btn-block">
                                Confirmar Solicitud
                            </button>
                        @endif
                    @elseif($solicitud['estado'] == 1 and in_array(Auth::user()->rol, array('Coordinador')))
                        <div class="form-group mt-3{{ $errors->has('observacion_requisitos') ? ' has-error' : '' }}">
                            <label for="observacion_requisitos">Observacion</label>
                            <textarea class="form-control" id="observacion_requisitos" name="observacion_requisitos" rows="3" placeholder="Observaciones en la Verificacion de Requisitos.">@if(old('observacion_requisitos')){{ old('observacion_requisitos') }}@else{{ $solicitud['observacion_requisitos'] }}@endif</textarea>
                            @if ($errors->has('observacion_requisitos'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('observacion_requisitos') }}</strong>
                                </span>
                            @endif
                        </div>
                        <input type="hidden" name="verificacion_requisitos" id="verificacion_requisitos" value="false">
                        <div class="row">
                            <div class="col-6">
                                <button type="submit" class="btn btn-danger btn-block">
                                    Rechasar Solicitud
                                </button>
                            </div>
                            <div class="col-6">
                                <button type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#exampleModalCenter">
                                    Confirmar Solicitud
                                </button>
                            </div>
                        </div>
                        <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLongTitle">Equipo Tecnico Encargado</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="trabajador_social_id">Trabajador Social</label>
                                            <select class="form-control" name="trabajador_social_id">
                                                @foreach($equipo['trabajador_socials'] as $trabajador_social)
                                                    <option value="{{ $trabajador_social['id'] }}">{{ $trabajador_social['nombres'] }} {{ $trabajador_social['apellido_paterno'] }} {{ $trabajador_social['apellido_materno'] }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="psicologo_id">Psicologo</label>
                                            <select class="form-control" name="psicologo_id">
                                                @foreach($equipo['psicologos'] as $psicologo)
                                                    <option value="{{ $psicologo['id'] }}">{{ $psicologo['nombres'] }} {{ $psicologo['apellido_paterno'] }} {{ $psicologo['apellido_materno'] }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="doctor_id">Doctor</label>
                                            <select class="form-control" name="doctor_id">
                                                @foreach($equipo['doctors'] as $doctor)
                                                    <option value="{{ $doctor['id'] }}">{{ $doctor['nombres'] }} {{ $doctor['apellido_paterno'] }} {{ $doctor['apellido_materno'] }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                                        <button type="submit" class="btn btn-success" onclick="ConfirmVerificacionRequisitos();">Asignar Solicitud</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </form>
                <script>
                    function ConfirmVerificacionRequisitos() {
                        $('#verificacion_requisitos').val(true);
                    }
                </script>
            </div>
        </div>
    </div>
@endsection


