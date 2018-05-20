@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mt-4 mb-3">Usuarios
            <small>Modificar</small>
        </h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ url('/') }}">Principal</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ url('/usuario') }}">Mostrar Usuarios</a>
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
        @if(isset($message['warning']) and $message['warning'])
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>Advertecia!</strong> {{ $message['warning_message'] }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        <div class="card mb-5">
            <div class="card-header">
                <i class="fa fa-table"></i> Datos del Usuario</div>
            <div class="card-body">
                <form class="form-horizontal" method="POST" action="{{ url('/usuario') }}/{{ $usuario['id'] }}">
                    {{ csrf_field() }}
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="_method" value="PUT" >
                    <div class="form-group">
                        <div class="form-row">
                            <div class="col-md-6{{ $errors->has('rol') ? ' has-error' : '' }}">
                                <label for="rol">Rol</label>
                                <input class="form-control" id="rol" type="text" name="rol" value="{{ $usuario['rol'] }}" aria-describedby="nameHelp" readonly>
                            </div>
                            <div class="col-md-4{{ $errors->has('ci') ? ' has-error' : '' }}">
                                <label for="ci">CI</label>
                                <input class="form-control" id="ci" type="text" name="ci" value="{{ $usuario['ci'] }}" aria-describedby="nameHelp" readonly>
                                @if ($errors->has('ci'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('ci') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="col-md-2{{ $errors->has('ci_extencion') ? ' has-error' : '' }}">
                                <label for="ci_extencion">Extencion</label>
                                <input class="form-control" id="ci_extencion" type="text" name="ci_extencion" value="{{ $usuario['ci_extencion'] }}" aria-describedby="nameHelp" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-row">
                            <div class="col-md-3{{ $errors->has('apellido_paterno') ? ' has-error' : '' }}">
                                <label for="apellido_paterno">Apellido Paterno</label>
                                <input class="form-control" id="apellido" type="text" name="apellido_paterno" @if(old('apellido_paterno')) value="{{ old('apellido_paterno') }}" @else value="{{ $usuario['apellido_paterno'] }}" @endif aria-describedby="nameHelp" placeholder="Ingrese el Apellido Paterno">
                                @if ($errors->has('apellido_paterno'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('apellido_paterno') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="col-md-3{{ $errors->has('apellido_materno') ? ' has-error' : '' }}">
                                <label for="apellido_materno">Apellido Materno</label>
                                <input class="form-control" id="apellido_materno" type="text" name="apellido_materno" @if(old('apellido_materno')) value="{{ old('apellido_materno') }}" @else value="{{ $usuario['apellido_materno'] }}" @endif aria-describedby="nameHelp" placeholder="Ingrese el Apellido Materno">
                                @if ($errors->has('apellido_materno'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('apellido_materno') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="col-md-6{{ $errors->has('nombres') ? ' has-error' : '' }}">
                                <label for="nombres">Nombres</label>
                                <input class="form-control" id="nombres" type="text" name="nombres" @if(old('nombres')) value="{{ old('nombres') }}" @else value="{{ $usuario['nombres'] }}" @endif aria-describedby="nameHelp" placeholder="Ingrese el Nombre">
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
                            <div class="col-md-6{{ $errors->has('email') ? ' has-error' : '' }}">
                                <label for="email">Direccion de Email</label>
                                <input class="form-control" id="email" type="email" name="email" value="{{ $usuario['email'] }}" aria-describedby="emailHelp" readonly>
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="col-md-3{{ $errors->has('genero') ? ' has-error' : '' }}">
                                <label for="genero">Genero</label>
                                <input class="form-control" id="genero" type="text" name="genero" value="{{ $usuario['genero'] }}" aria-describedby="nameHelp" readonly>
                            </div>
                            <div class="col-md-3{{ $errors->has('fecha_nacimiento') ? ' has-error' : '' }}">
                                <label for="fecha_nacimiento">Fecha de Nacimiento</label>
                                <input class="form-control text-right" id="fecha_nacimiento" type="date" name="fecha_nacimiento" value="{{ $usuario['fecha_nacimiento'] }}" aria-describedby="emailHelp" readonly>
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
                            <div class="col-md-6{{ $errors->has('telefono_fijo') ? ' has-error' : '' }}">
                                <label for="telefono_fijo">Telefono Fijo</label>
                                <input class="form-control text-right" id="telefono_fijo" type="text" name="telefono_fijo" @if(old('telefono_fijo')) value="{{ old('telefono_fijo') }}" @else value="{{ $usuario['telefono_fijo'] }}" @endif aria-describedby="nameHelp" placeholder="Ingrese el Telefono Fijo">
                                @if ($errors->has('telefono_fijo'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('telefono_fijo') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="col-md-6{{ $errors->has('telefono_celular') ? ' has-error' : '' }}">
                                <label for="telefono_celular">Telefono Celular</label>
                                <input class="form-control text-right" id="telefono_celular" type="text" name="telefono_celular" @if(old('telefono_celular')) value="{{ old('telefono_celular') }}" @else value="{{ $usuario['telefono_celular'] }}" @endif aria-describedby="nameHelp" placeholder="Ingrese el Telefono Celular">
                                @if ($errors->has('telefono_celular'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('telefono_celular') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
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


