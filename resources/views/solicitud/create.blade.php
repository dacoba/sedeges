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
                <form class="form-horizontal" id="form_solicitud" method="POST" action="{{ url('/solicitud') }}" enctype="multipart/form-data">
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
                                <input class="form-control text-right" id="infante_edad_desde" type="text" name="infante_edad_desde" value="{{ old('infante_edad_desde') }}" aria-describedby="nameHelp" placeholder="Desde cuantos años">
                                @if ($errors->has('infante_edad_desde'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('infante_edad_desde') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="col-md-2{{ $errors->has('infante_edad_hasta') ? ' has-error' : '' }}">
                                <label for="infante_edad_hasta">Edad Hasta</label>
                                <input class="form-control text-right" id="infante_edad_hasta" type="text" name="infante_edad_hasta" value="{{ old('infante_edad_hasta') }}" aria-describedby="nameHelp" placeholder="Hasta cuantos años">
                                @if ($errors->has('infante_edad_hasta'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('infante_edad_hasta') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    @foreach($DocumentsTypes as $item)
                        <div class="form-group">
                            <div class="form-row">
                                <div class="col-md-5"></div>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="carta_solicitud" disabled>
                                    <label class="custom-control-label" for="carta_solicitud">{{ $item }}</label>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <div class="form-group">
                        <div class="form-row">
                            <div class="col-md-4{{ $errors->has('doc_type') ? ' has-error' : '' }}">
                                <label for="doc_type">Documento</label>
                                <select class="form-control" name="doc_type">
                                    @while($item = current($DocumentsTypes))
                                        <option value="{{key($DocumentsTypes)}}" @if(old('doc_type') == key($DocumentsTypes)) selected @endif>{{ $item }}</option>
                                        <?php next($DocumentsTypes) ?>
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
                        <textarea class="form-control" id="observacion_registro" name="observacion_registro" rows="3" placeholder="Observaciones de la Solicitud de Adopcion.">{{ old('observacion_registro') }}</textarea>
                        @if ($errors->has('observacion_registro'))
                            <span class="help-block">
                                <strong>{{ $errors->first('observacion_registro') }}</strong>
                            </span>
                        @endif
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">
                        Registrar Solicitud
                    </button>
                    {{--<a class="btn btn-primary btn-block" href="login.html">Register</a>--}}
                </form>
            </div>
        </div>
    </div>
@endsection


