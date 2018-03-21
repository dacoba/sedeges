@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mt-4 mb-3">Infantes
            <small>Modificar</small>
        </h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ url('/') }}">Principal</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ url('/infante') }}">Mostrar Infantes</a>
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
                <i class="fa fa-table"></i> Datos del Centro</div>
            <div class="card-body">
                <form class="form-horizontal" method="POST" action="{{ url('/infante') }}/{{ $infante['id'] }}">
                    {{ csrf_field() }}
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="_method" value="PUT" >
                    <div class="form-group">
                        <div class="form-row">
                            <div class="col-md-6{{ $errors->has('nombre') ? ' has-error' : '' }}">
                                <label for="nombre">Nombre del Infante</label>
                                <input class="form-control" id="nombre" type="text" name="nombre" @if(old('nombre')) value="{{ old('nombre') }}" @else value="{{ $infante['nombre'] }}" @endif aria-describedby="nameHelp" placeholder="Ingrese el Nombre del Infante">
                                @if ($errors->has('nombre'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('nombre') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="col-md-3{{ $errors->has('fecha_nacimiento') ? ' has-error' : '' }}">
                                <label for="fecha_nacimiento">Fecha de Nacimiento</label>
                                <input class="form-control text-right" id="fecha_nacimiento" type="date" name="fecha_nacimiento" value="{{ $infante['fecha_nacimiento'] }}" aria-describedby="emailHelp" placeholder="Ingrese la Fecha de Nacimiento del Infante" readonly>
                                @if ($errors->has('fecha_nacimiento'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('fecha_nacimiento') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="col-md-3{{ $errors->has('genero') ? ' has-error' : '' }}">
                                <label for="genero">Genero</label>
                                <input class="form-control" id="genero" type="text" name="genero" value="{{ $infante['genero'] }}" aria-describedby="nameHelp" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-row">
                            <div class="col-md-6{{ $errors->has('centro_id') ? ' has-error' : '' }}">
                                <label for="centro_id">Centro</label>
                                <select class="form-control" name="centro_id">
                                    @foreach($centros as $centro)
                                        <option value="{{ $centro['id'] }}" @if($infante['centro_id'] == $centro['id']) selected @endif>{{ $centro['nombre_centro'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6{{ $errors->has('fecha_ingreso') ? ' has-error' : '' }}">
                                <label for="fecha_ingreso">Fecha de Ingreso</label>
                                <input class="form-control text-right" id="fecha_ingreso" type="date" name="fecha_ingreso" @if(old('fecha_ingreso')) value="{{ old('fecha_ingreso') }}" @else value="{{ $infante['fecha_ingreso'] }}" @endif aria-describedby="emailHelp" placeholder="Ingrese la Fecha de Ingreso al Centro">
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
                                <input class="form-control" id="ci" type="text" name="ci" @if(old('ci')) value="{{ old('ci') }}" @else value="{{ $infante['ci'] }}" @endif aria-describedby="nameHelp" placeholder="CI del usuario">
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
                                        <option @if($infante['ci_extencion'] == $extencion) selected @endif>{{ $extencion }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3{{ $errors->has('ci_extencion') ? ' has-error' : '' }}">
                                <label for="ci_extencion">Habilitado</label>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="habilitado" name="habilitado" @if($infante['habilitado']) checked @endif>
                                    <label class="custom-control-label" for="habilitado">Habilitado para ser adoptado</label>
                                </div>
                            </div>
                            <div class="col-md-3{{ $errors->has('ci_extencion') ? ' has-error' : '' }}">
                                <label for="ci_extencion">Adoptado</label>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="adoptado" name="adoptado" @if($infante['adoptado']) checked @endif>
                                    <label class="custom-control-label" for="adoptado">Ya esta adoptado</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('descripcion') ? ' has-error' : '' }}">
                        <label for="descripcion">Descripcion del Infante</label>
                        <input class="form-control" id="descripcion" type="text" name="descripcion" @if(old('descripcion')) value="{{ old('descripcion') }}" @else value="{{ $infante['descripcion'] }}" @endif aria-describedby="nameHelp" placeholder="Ingrese la Descripcion del Infante">
                        @if ($errors->has('descripcion'))
                            <span class="help-block">
                            <strong>{{ $errors->first('descripcion') }}</strong>
                        </span>
                        @endif
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">
                        Actualizar Usuario
                    </button>
                    {{--<a class="btn btn-primary btn-block" href="login.html">Register</a>--}}
                </form>
            </div>
        </div>
    </div>
@endsection


