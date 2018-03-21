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
                        <div class="form-row">
                            <div class="col-md-6{{ $errors->has('adoptante_id') ? ' has-error' : '' }}">
                                <label for="adoptante_id">Adoptante</label>
                                <input class="form-control" id="adoptante_id" type="text" name="adoptante_id" value="{{ $solicitud['adoptante']['user']['ci'] }} {{ $solicitud['adoptante']['user']['ci_extencion'] }} - {{ $solicitud['adoptante']['user']['nombres'] }} {{ $solicitud['adoptante']['user']['apellido_paterno'] }} {{ $solicitud['adoptante']['user']['apellido_materno'] }}" aria-describedby="nameHelp" placeholder="Ingrese al Edad del Infante" readonly>
                            </div>
                            <div class="col-md-2{{ $errors->has('infante_genero') ? ' has-error' : '' }}">
                                <label for="infante_genero">Genero del Infante</label>
                                <input class="form-control" id="infante_genero" type="text" name="infante_genero" value="{{ $solicitud['infante_genero'] }}" aria-describedby="nameHelp" placeholder="Ingrese al Edad del Infante" readonly>
                            </div>
                            <div class="col-md-2{{ $errors->has('infante_edad_desde') ? ' has-error' : '' }}">
                                <label for="infante_edad_desde">Edad Desde</label>
                                <input class="form-control" id="infante_edad_desde" type="text" name="infante_edad_desde" value="{{ $solicitud['infante_edad_desde'] }}" aria-describedby="nameHelp" placeholder="Ingrese al Edad del Infante" readonly>
                                @if ($errors->has('infante_edad_desde'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('infante_edad_desde') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="col-md-2{{ $errors->has('infante_edad_hasta') ? ' has-error' : '' }}">
                                <label for="infante_edad_hasta">Edad Hasta</label>
                                <input class="form-control" id="infante_edad_hasta" type="text" name="infante_edad_hasta" value="{{ $solicitud['infante_edad_hasta'] }}" aria-describedby="nameHelp" placeholder="Ingrese al Edad del Infante" readonly>
                                @if ($errors->has('infante_edad_hasta'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('infante_edad_hasta') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    @if (in_array($solicitud['estado'], array(0, 1)))
                        <div class="form-group">
                            <div class="form-row">
                                <div class="col-md-5"></div>
                                <div class="{{ $errors->has('carta_solicitud') ? ' has-error' : '' }}">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="carta_solicitud" name="carta_solicitud" @if(old('carta_solicitud') and old('carta_solicitud') == 'on') checked @elseif($solicitud['carta_solicitud']) checked @endif @if($solicitud['estado'] == 1) disabled @endif>
                                        <label class="custom-control-label" for="carta_solicitud">Carta Solicitud</label>
                                        @if ($errors->has('carta_solicitud'))
                                            <br><span class="help-block">
                                                <strong>{{ $errors->first('carta_solicitud') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-row">
                                <div class="col-md-5"></div>
                                <div class="{{ $errors->has('certificado_antecedentes') ? ' has-error' : '' }}">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="certificado_antecedentes" name="certificado_antecedentes" @if(old('certificado_antecedentes') and old('certificado_antecedentes') == 'on') checked @elseif($solicitud['certificado_antecedentes']) checked @endif @if($solicitud['estado'] == 1) disabled @endif>
                                        <label class="custom-control-label" for="certificado_antecedentes">Certificado de Antecedentes</label>
                                        @if ($errors->has('certificado_antecedentes'))
                                            <br><span class="help-block">
                                                <strong>{{ $errors->first('certificado_antecedentes') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-row">
                                <div class="col-md-5"></div>
                                <div class="{{ $errors->has('informe_antecedentes') ? ' has-error' : '' }}">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="informe_antecedentes" name="informe_antecedentes" @if(old('informe_antecedentes') and old('informe_antecedentes') == 'on') checked @elseif($solicitud['informe_antecedentes']) checked @endif @if($solicitud['estado'] == 1) disabled @endif>
                                        <label class="custom-control-label" for="informe_antecedentes">Informe Antecedentes</label>
                                        @if ($errors->has('informe_antecedentes'))
                                            <br><span class="help-block">
                                                <strong>{{ $errors->first('informe_antecedentes') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-row">
                                <div class="col-md-5"></div>
                                <div class="{{ $errors->has('verificacion_domiciliaria') ? ' has-error' : '' }}">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="verificacion_domiciliaria" name="verificacion_domiciliaria" @if(old('verificacion_domiciliaria') and old('verificacion_domiciliaria') == 'on') checked @elseif($solicitud['verificacion_domiciliaria']) checked @endif @if($solicitud['estado'] == 1) disabled @endif>
                                        <label class="custom-control-label" for="verificacion_domiciliaria">Verificacion Domiciliaria</label>
                                        @if ($errors->has('verificacion_domiciliaria'))
                                            <br><span class="help-block">
                                                <strong>{{ $errors->first('verificacion_domiciliaria') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-row">
                                <div class="col-md-5"></div>
                                <div class="{{ $errors->has('certificado_estadocivil') ? ' has-error' : '' }}">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="certificado_estadocivil" name="certificado_estadocivil" @if(old('certificado_estadocivil') and old('certificado_estadocivil') == 'on') checked @elseif($solicitud['certificado_estadocivil']) checked @endif @if($solicitud['estado'] == 1) disabled @endif>
                                        <label class="custom-control-label" for="certificado_estadocivil">Certificado Estado Civil</label>
                                        @if ($errors->has('certificado_estadocivil'))
                                            <br><span class="help-block">
                                                <strong>{{ $errors->first('certificado_estadocivil') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    @if (in_array($solicitud['estado'], array(0, 1)))
                        @if($documents->count() > 0)
                            <h3>Documentos de la Solicitud
                                <span class="pull-right">
                                    <small>Acciones</small>
                                </span>
                            </h3>
                            <ul class="list-group list-group-flush">
                                @foreach($documents as $document)
                                    <li class="list-group-item text-primary" style="padding: .75rem 0rem;"><strong>{{$doc_registro[$document['type']]}}</strong> {{$document['name']}}
                                        <span class="pull-right">
                                            @if(in_array($document['mime'], array("image/png", "application/pdf", "image/jpeg")))
                                                <a class="btn btn-primary btn-sm" target="_blank" href="{{ url('/document') }}/{{$document['id']}}" data-toggle="tooltip" data-placement="top" title="Ver"><i class="fa fa-eye"></i></a>
                                            @endif
                                            <a class="btn btn-success btn-sm" href="{{ url('/document/download') }}/{{$document['id']}}" data-toggle="tooltip" data-placement="top" title="Descargar"><i class="fa fa-download"></i></a>
                                        </span>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    @endif
                    @if ($solicitud['estado'] == 0)
                        <div class="form-group">
                            <div class="form-row">
                                <div class="col-md-4{{ $errors->has('doc_type') ? ' has-error' : '' }}">
                                    <label for="doc_type">Documento</label>
                                    <select class="form-control" name="doc_type">
                                        @while($item = current($doc_registro))
                                            <option value="{{key($doc_registro)}}" @if(old('doc_type') == key($doc_registro)) selected @endif>{{ $item }}</option>
                                            <?php next($doc_registro) ?>
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
                        <div class="form-group{{ $errors->has('observacion_registro') ? ' has-error' : '' }}">
                            <label for="observacion_registro">Observacion</label>
                            <textarea class="form-control" id="observacion_registro" name="observacion_registro" rows="3" placeholder="Observaciones de la Solicitud de Adopcion.">@if(old('observacion_registro')) {{ old('observacion_registro') }} @else {{ $solicitud['observacion_registro'] }} @endif</textarea>
                            @if ($errors->has('observacion_registro'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('observacion_registro') }}</strong>
                                </span>
                            @endif
                        </div>
                        <input type="hidden" name="verificacion_registro" id="verificacion_registro" value="false">
                        <div class="row">
                            <div class="col-6">
                                <button type="submit" class="btn btn-primary btn-block">
                                    Actualizar Solicitud
                                </button>
                            </div>
                            <div class="col-6">
                                <button type="submit" id="submit" class="btn btn-success btn-block" onClick="ConfirmVerificacionRegistro();">
                                    Actualizar Y Confirmar Solicitud
                                </button>
                            </div>
                        </div>
                    @elseif($solicitud['estado'] == 1)
                        <div class="form-group{{ $errors->has('observacion_requisitos') ? ' has-error' : '' }}">
                            <label for="observacion_requisitos">Observacion</label>
                            <textarea class="form-control" id="observacion_requisitos" name="observacion_requisitos" rows="3" placeholder="Observaciones de la Solicitud de Adopcion.">@if(old('observacion_requisitos')) {{ old('observacion_requisitos') }} @else {{ $solicitud['observacion_requisitos'] }} @endif</textarea>
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
                                <button type="submit" id="submit" class="btn btn-success btn-block" onClick="ConfirmVerificacionRequisitos();">
                                    Confirmar Solicitud
                                </button>
                            </div>
                        </div>
                    @endif
                </form>
                <script>
                    function ConfirmVerificacionRegistro() {
                        $('#verificacion_registro').val(true);
                    }
                    function ConfirmVerificacionRequisitos() {
                        $('#verificacion_requisitos').val(true);
                    }
                </script>
            </div>
        </div>
    </div>
@endsection


