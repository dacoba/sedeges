@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mt-4 mb-3">Adoptantes
            <small>Modificar</small>
        </h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ url('/') }}">Principal</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ url('/adoptante') }}">Mostrar Adoptantes</a>
            </li>
            <li class="breadcrumb-item active">Modificar</li>
        </ol>
        @include('messages')
        <div class="card mb-5">
            <div class="card-header">
                <i class="fa fa-table"></i> Datos del Usuario</div>
            <div class="card-body">
                <form class="form-horizontal" method="POST" action="{{ url('/adoptante') }}/{{ $adoptante['id'] }}">
                    {{ csrf_field() }}
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="_method" value="PUT" >
                    <div class="form-group">
                        <div class="form-row">
                            <div class="col-md-3{{ $errors->has('apellido_paterno') ? ' has-error' : '' }}">
                                <label for="apellido_paterno">Apellido Paterno</label>
                                <input class="form-control" id="apellido" type="text" name="apellido_paterno" value="{{ $adoptante['user']['apellido_paterno'] }}" aria-describedby="nameHelp" placeholder="Ingrese el Apellido Paterno" readonly>
                                @if ($errors->has('apellido_paterno'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('apellido_paterno') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="col-md-3{{ $errors->has('apellido_materno') ? ' has-error' : '' }}">
                                <label for="apellido_materno">Apellido Materno</label>
                                <input class="form-control" id="apellido_materno" type="text" name="apellido_materno" value="{{ $adoptante['user']['apellido_materno'] }}" aria-describedby="nameHelp" placeholder="Ingrese el Apellido Materno" readonly>
                                @if ($errors->has('apellido_materno'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('apellido_materno') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="col-md-6{{ $errors->has('nombres') ? ' has-error' : '' }}">
                                <label for="nombres">Nombres</label>
                                <input class="form-control" id="nombres" type="text" name="nombres" value="{{ $adoptante['user']['nombres'] }}" aria-describedby="nameHelp" placeholder="Ingrese el Nombre" readonly>
                                @if ($errors->has('nombres'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('nombres') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-row">
                            <div class="col-md-4{{ $errors->has('ci') ? ' has-error' : '' }}">
                                <label for="ci">CI</label>
                                <input class="form-control" id="ci" type="text" name="ci" value="{{ $adoptante['user']['ci'] }}" aria-describedby="nameHelp" placeholder="CI del usuario" readonly>
                                @if ($errors->has('ci'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('ci') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="col-md-2{{ $errors->has('ci_extencion') ? ' has-error' : '' }}">
                                <label for="ci_extencion">Extencion</label>
                                <input class="form-control" id="ci_extencion" type="text" name="ci_extencion" value="{{ $adoptante['user']['ci_extencion'] }}" aria-describedby="nameHelp" readonly>
                            </div>
                            <div class="col-md-3{{ $errors->has('estado_civil') ? ' has-error' : '' }}">
                                <label for="estado_civil">Estado Civil</label>
                                <select class="form-control" name="estado_civil">
                                    @foreach($estado_civil as $estado)
                                        <option @if($adoptante['estado_civil'] == $estado) selected @endif>{{ $estado }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3{{ $errors->has('ocupacion') ? ' has-error' : '' }}">
                                <label for="ocupacion">Ocupacion</label>
                                <input class="form-control" id="ocupacion" type="text" name="ocupacion" @if(old('ocupacion')) value="{{ old('ocupacion') }}" @else value="{{ $adoptante['ocupacion'] }}" @endif aria-describedby="nameHelp" placeholder="Ocupacion del Adoptante">
                                @if ($errors->has('ocupacion'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('ocupacion') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-row">
                            <div class="col-md-9{{ $errors->has('email') ? ' has-error' : '' }}">
                                <label for="email">Direccion de Email</label>
                                <input class="form-control" id="email" type="email" name="email" value="{{ $adoptante['user']['email'] }}" aria-describedby="emailHelp" placeholder="Ingrese la Direccion de Email" readonly>
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="col-md-3{{ $errors->has('fecha_nacimiento') ? ' has-error' : '' }}">
                                <label for="fecha_nacimiento">Fecha de Nacimiento</label>
                                <input class="form-control text-right" id="fecha_nacimiento" type="date" name="fecha_nacimiento" value="{{ $adoptante['user']['fecha_nacimiento']->format('Y-m-d') }}" aria-describedby="emailHelp" placeholder="Ingrese la Fecha de Nacimiento" readonly>
                                @if ($errors->has('fecha_nacimiento'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('fecha_nacimiento') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-row">
                            <div class="col-md-4{{ $errors->has('telefono_fijo') ? ' has-error' : '' }}">
                                <label for="telefono_fijo">Telefono Fijo</label>
                                <input class="form-control text-right" id="telefono_fijo" type="text" name="telefono_fijo" @if(old('telefono_fijo')) value="{{ old('telefono_fijo') }}" @else value="{{ $adoptante['user']['telefono_fijo'] }}" @endif aria-describedby="nameHelp" placeholder="Ingrese el Telefono Fijo">
                                @if ($errors->has('telefono_fijo'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('telefono_fijo') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="col-md-4{{ $errors->has('telefono_celular') ? ' has-error' : '' }}">
                                <label for="telefono_celular">Telefono Celular</label>
                                <input class="form-control text-right" id="telefono_celular" type="text" name="telefono_celular" @if(old('telefono_celular')) value="{{ old('telefono_celular') }}" @else value="{{ $adoptante['user']['telefono_celular'] }}" @endif aria-describedby="nameHelp" placeholder="Ingrese el Telefono Celular">
                                @if ($errors->has('telefono_celular'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('telefono_celular') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="col-md-4{{ $errors->has('habilitado') ? ' has-error' : '' }}">
                                <label for="habilitado">Adopcion</label>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="habilitado" name="habilitado" @if($adoptante['habilitado']) checked @endif>
                                    <label class="custom-control-label" for="habilitado">El Adoptante puede adoptar</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('direccion') ? ' has-error' : '' }}">
                        <label for="direccion">Direccion del Adoptante</label>
                        <input class="form-control" id="direccion" type="text" name="direccion" @if(old('direccion')) value="{{ old('direccion') }}" @else value="{{ $adoptante['direccion'] }}" @endif aria-describedby="nameHelp" placeholder="Ingrese la Direccion del Adoptante">
                        @if ($errors->has('direccion'))
                            <span class="help-block">
                            <strong>{{ $errors->first('direccion') }}</strong>
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


