@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mt-4 mb-3">Centros
            <small>Registrar</small>
        </h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ url('/') }}">Principal</a>
            </li>
            <li class="breadcrumb-item active">Registrar Infantes</li>
        </ol>
        <div class="card mb-5">
            <div class="card-header">
                <i class="fa fa-table"></i> Registro de Infante</div>
            <div class="card-body">
                <form class="form-horizontal" method="POST" action="{{ url('/infante') }}">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <div class="form-row">
                            <div class="col-md-6{{ $errors->has('nombre') ? ' has-error' : '' }}">
                                <label for="nombre">Nombre del Infante</label>
                                <input class="form-control" id="nombre" type="text" name="nombre" value="{{ old('nombre') }}" aria-describedby="nameHelp" placeholder="Ingrese el Nombre del Infante">
                                @if ($errors->has('nombre'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('nombre') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="col-md-3{{ $errors->has('fecha_nacimiento') ? ' has-error' : '' }}">
                                <label for="fecha_nacimiento">Fecha de Nacimiento</label>
                                <input class="form-control text-right" id="fecha_nacimiento" type="date" name="fecha_nacimiento" value="{{ old('fecha_nacimiento') }}" aria-describedby="emailHelp" placeholder="Ingrese la Fecha de Nacimiento del Infante">
                                @if ($errors->has('fecha_nacimiento'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('fecha_nacimiento') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="col-md-3{{ $errors->has('genero') ? ' has-error' : '' }}">
                                <label for="genero">Genero</label>
                                <select class="form-control" name="genero">
                                    <option @if(old('genero') == 'Masculino') selected @endif>Masculino</option>
                                    <option @if(old('genero') == 'Femenino') selected @endif>Femenino</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-row">
                            <div class="col-md-6{{ $errors->has('centro_id') ? ' has-error' : '' }}">
                                <label for="centro_id">Centro</label>
                                <select class="form-control" name="centro_id">
                                    @foreach($centros as $centro)
                                        <option value="{{ $centro['id'] }}" @if(old('centro_id') == $centro['id']) selected @endif>{{ $centro['nombre_centro'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6{{ $errors->has('fecha_ingreso') ? ' has-error' : '' }}">
                                <label for="fecha_ingreso">Fecha de Ingreso</label>
                                <input class="form-control text-right" id="fecha_ingreso" type="date" name="fecha_ingreso" value="{{ old('fecha_ingreso') }}" aria-describedby="emailHelp" placeholder="Ingrese la Fecha de Ingreso al Centro">
                                @if ($errors->has('fecha_ingreso'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('fecha_ingreso') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-row">
                            <div class="col-md-4{{ $errors->has('ci') ? ' has-error' : '' }}">
                                <label for="ci">CI</label>
                                <input class="form-control" id="ci" type="text" name="ci" value="{{ old('ci') }}" aria-describedby="nameHelp" placeholder="CI del usuario">
                                @if ($errors->has('ci'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('ci') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="col-md-2{{ $errors->has('ci_extencion') ? ' has-error' : '' }}">
                                <label for="ci_extencion">Extencion</label>
                                <select class="form-control" name="ci_extencion">
                                    @foreach($extenciones as $extencion)
                                        <option @if(old('ci_extencion') == $extencion) selected @endif>{{ $extencion }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3{{ $errors->has('habilitado') ? ' has-error' : '' }}">
                                <label for="habilitado">Habilitado</label>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="habilitado" name="habilitado" checked>
                                    <label class="custom-control-label" for="habilitado">Habilitado para ser adoptado</label>
                                </div>
                            </div>
                            <div class="col-md-3{{ $errors->has('adoptado') ? ' has-error' : '' }}">
                                <label for="adoptado">Adoptado</label>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="adoptado" name="adoptado">
                                    <label class="custom-control-label" for="adoptado">Ya esta adoptado</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('descripcion') ? ' has-error' : '' }}">
                        <label for="descripcion">Descripcion del Infante</label>
                        <input class="form-control" id="descripcion" type="text" name="descripcion" value="{{ old('descripcion') }}" aria-describedby="nameHelp" placeholder="Ingrese la Descripcion del Infante">
                        @if ($errors->has('descripcion'))
                            <span class="help-block">
                            <strong>{{ $errors->first('descripcion') }}</strong>
                        </span>
                        @endif
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">
                        Registrar Infante
                    </button>
                    {{--<a class="btn btn-primary btn-block" href="login.html">Register</a>--}}
                </form>
            </div>
        </div>
    </div>
@endsection


