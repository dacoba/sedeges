@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mt-4 mb-3">Solicitudes de Adopcion
            <small>Registrar</small>
        </h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ url('/') }}">Principal</a>
            </li>
            <li class="breadcrumb-item active">Registrar Solicitudes de Adopcion</li>
        </ol>
        <div class="card mb-5">
            <div class="card-header">
                <i class="fa fa-table"></i> Registro de Solicitud de Adopcion</div>
            <div class="card-body">
                <form class="form-horizontal" id="form_solicitud" method="POST" action="{{ url('/solicitud') }}">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <div class="form-row">
                            <div class="col-md-6{{ $errors->has('adoptante') ? ' has-error' : '' }}">
                                <label for="adoptante">Adoptante</label>
                                <input id="adoptante_search" name="adoptante" class="form-control" type="text" placeholder="Ingrese el CI del adoptante" value="{{ old('adoptante') }}">
                                @if ($errors->has('adoptante'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('adoptante') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <input type="hidden" name="adoptante_user_id" id="adoptante_user_id" value="{{ old('adoptante_user_id') }}">
                            <div class="col-md-2{{ $errors->has('infante_genero') ? ' has-error' : '' }}">
                                <label for="infante_genero">Genero del Infante</label>
                                <select class="form-control" name="infante_genero">
                                    <option @if(old('infante_genero') == 'Masculino') selected @endif>Masculino</option>
                                    <option @if(old('infante_genero') == 'Femenino') selected @endif>Femenino</option>
                                </select>
                            </div>
                            <div class="col-md-2{{ $errors->has('infante_edad_desde') ? ' has-error' : '' }}">
                                <label for="infante_edad_desde">Edad Desde</label>
                                <input class="form-control" id="infante_edad_desde" type="text" name="infante_edad_desde" value="{{ old('infante_edad_desde') }}" aria-describedby="nameHelp" placeholder="Desde cuantos años">
                                @if ($errors->has('infante_edad_desde'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('infante_edad_desde') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="col-md-2{{ $errors->has('infante_edad_hasta') ? ' has-error' : '' }}">
                                <label for="infante_edad_hasta">Edad Hasta</label>
                                <input class="form-control" id="infante_edad_hasta" type="text" name="infante_edad_hasta" value="{{ old('infante_edad_hasta') }}" aria-describedby="nameHelp" placeholder="Hasta cuantos años">
                                @if ($errors->has('infante_edad_hasta'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('infante_edad_hasta') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-row">
                            <div class="col-md-5"></div>
                            <div class="{{ $errors->has('carta_solicitud') ? ' has-error' : '' }}">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="carta_solicitud" name="carta_solicitud" @if(old('carta_solicitud') and old('carta_solicitud') == 'on') checked @endif>
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
                                    <input type="checkbox" class="custom-control-input" id="certificado_antecedentes" name="certificado_antecedentes" @if(old('certificado_antecedentes') and old('certificado_antecedentes') == 'on') checked @endif>
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
                                    <input type="checkbox" class="custom-control-input" id="informe_antecedentes" name="informe_antecedentes" @if(old('informe_antecedentes') and old('informe_antecedentes') == 'on') checked @endif>
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
                                    <input type="checkbox" class="custom-control-input" id="verificacion_domiciliaria" name="verificacion_domiciliaria" @if(old('verificacion_domiciliaria') and old('verificacion_domiciliaria') == 'on') checked @endif>
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
                                    <input type="checkbox" class="custom-control-input" id="certificado_estadocivil" name="certificado_estadocivil" @if(old('certificado_estadocivil') and old('certificado_estadocivil') == 'on') checked @endif>
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
                    <div class="form-group{{ $errors->has('observacion_registro') ? ' has-error' : '' }}">
                        <label for="observacion_registro">Observacion</label>
                        <textarea class="form-control" id="observacion_registro" name="observacion_registro" rows="3" placeholder="Observaciones de la Solicitud de Adopcion.">{{ old('observacion_registro') }}</textarea>
                        @if ($errors->has('observacion_registro'))
                            <span class="help-block">
                                <strong>{{ $errors->first('observacion_registro') }}</strong>
                            </span>
                        @endif
                    </div>
                    <input type="hidden" name="confirm" id="confirm" value="false">
                    <div class="row">
                        <div class="col-6">
                            <button type="submit" class="btn btn-primary btn-block">
                                Registrar Solicitud
                            </button>
                        </div>
                        <div class="col-6">
                            <button type="submit" id="submit" class="btn btn-success btn-block" onClick="confirmSolicitud();">
                                Registrar Y Confirmar Solicitud
                            </button>
                        </div>
                    </div>
                    {{--<a class="btn btn-primary btn-block" href="login.html">Register</a>--}}
                </form>
                <script>
                    function confirmSolicitud() {
                        $('#confirm').val(true);
                        $('#form_solicitud').submit();
                    }
                </script>
            </div>
        </div>
    </div>
@endsection


