@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mt-4 mb-3">Usuarios
            <small>Registrar</small>
        </h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ url('/') }}">Principal</a>
            </li>
            <li class="breadcrumb-item active">Registrar Usuarios</li>
        </ol>
        <div class="card mb-5">
            <div class="card-header">
                <i class="fa fa-table"></i> Registro de Usuario</div>
            <div class="card-body">
                <form class="form-horizontal" method="POST" action="{{ url('/usuario') }}">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <div class="form-row">
                            <div class="col-md-6{{ $errors->has('rol') ? ' has-error' : '' }}">
                                <label for="rol">Rol</label>
                                <select class="form-control" name="rol">
                                    @foreach($roles as $rol)
                                        <option @if(old('rol') == $rol) selected @endif>{{ $rol }}</option>
                                    @endforeach
                                </select>
                            </div>
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
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-row">
                            <div class="col-md-3{{ $errors->has('apellido_paterno') ? ' has-error' : '' }}">
                                <label for="apellido_paterno">Apellido Paterno</label>
                                <input class="form-control" id="apellido" type="text" name="apellido_paterno" value="{{ old('apellido_paterno') }}" aria-describedby="nameHelp" placeholder="Ingrese el Apellido Paterno">
                                @if ($errors->has('apellido_paterno'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('apellido_paterno') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="col-md-3{{ $errors->has('apellido_materno') ? ' has-error' : '' }}">
                                <label for="apellido_materno">Apellido Materno</label>
                                <input class="form-control" id="apellido_materno" type="text" name="apellido_materno" value="{{ old('apellido_materno') }}" aria-describedby="nameHelp" placeholder="Ingrese el Apellido Materno">
                                @if ($errors->has('apellido_materno'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('apellido_materno') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="col-md-6{{ $errors->has('nombres') ? ' has-error' : '' }}">
                                <label for="nombres">Nombres</label>
                                <input class="form-control" id="nombres" type="text" name="nombres" value="{{ old('nombres') }}" aria-describedby="nameHelp" placeholder="Ingrese el Nombre">
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
                                <input class="form-control" id="email" type="email" name="email" value="{{ old('email') }}" aria-describedby="emailHelp" placeholder="Ingrese la Direccion de Email">
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
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
                            <div class="col-md-3{{ $errors->has('fecha_nacimiento') ? ' has-error' : '' }}">
                                <label for="fecha_nacimiento">Fecha de Nacimiento</label>
                                <input class="form-control text-right" id="fecha_nacimiento" type="date" name="fecha_nacimiento" value="{{ old('fecha_nacimiento') }}" aria-describedby="emailHelp" placeholder="Ingrese la Fecha de Nacimiento">
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
                                <input class="form-control" id="telefono_fijo" type="text" name="telefono_fijo" value="{{ old('telefono_fijo') }}" aria-describedby="nameHelp" placeholder="Ingrese el Telefono Fijo">
                                @if ($errors->has('telefono_fijo'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('telefono_fijo') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="col-md-6{{ $errors->has('telefono_celular') ? ' has-error' : '' }}">
                                <label for="telefono_celular">Telefono Celular</label>
                                <input class="form-control" id="telefono_celular" type="text" name="telefono_celular" value="{{ old('telefono_celular') }}" aria-describedby="nameHelp" placeholder="Ingrese el Telefono Celular">
                                @if ($errors->has('telefono_celular'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('telefono_celular') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-row">
                            <div class="col-md-6{{ $errors->has('password') ? ' has-error' : '' }}">
                                <label for="password">Contraseña</label>
                                <input class="form-control" id="password" name="password" type="password" placeholder="Contraseña">
                                @if ($errors->has('password'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="col-md-6">
                                <label for="password-confirm">Confirmacion de Contraseña</label>
                                <input class="form-control" id="password-confirm" type="password" name="password_confirmation" placeholder="Confirmacion de Contraseña">
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">
                        Registrar Usuario
                    </button>
                    {{--<a class="btn btn-primary btn-block" href="login.html">Register</a>--}}
                </form>
            </div>
        </div>
    </div>
@endsection


