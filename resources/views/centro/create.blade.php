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
            <li class="breadcrumb-item active">Registrar Centros</li>
        </ol>
        <div class="card mb-5">
            <div class="card-header">
                <i class="fa fa-table"></i> Registro de Centro</div>
            <div class="card-body">
                <form class="form-horizontal" method="POST" action="{{ url('/centro') }}">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <div class="form-row">
                            <div class="col-md-4{{ $errors->has('nombre_centro') ? ' has-error' : '' }}">
                                <label for="nombre_centro">Nombre del Centro</label>
                                <input class="form-control" id="nombre_centro" type="text" name="nombre_centro" value="{{ old('nombre_centro') }}" aria-describedby="emailHelp" placeholder="Ingrese el Nombre del Centro">
                                @if ($errors->has('nombre_centro'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('nombre_centro') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="col-md-4{{ $errors->has('capacidad') ? ' has-error' : '' }}">
                                <label for="capacidad">Nombre del Centro</label>
                                <input class="form-control" id="capacidad" type="text" name="capacidad" value="{{ old('capacidad') }}" aria-describedby="emailHelp" placeholder="Ingrese el Nombre del Centro">
                                @if ($errors->has('capacidad'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('capacidad') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="col-md-4{{ $errors->has('telefono') ? ' has-error' : '' }}">
                                <label for="telefono">Telefono</label>
                                <input class="form-control" id="telefono" type="text" name="telefono" value="{{ old('telefono') }}" aria-describedby="nameHelp" placeholder="Ingrese el Telefono del Centro">
                                @if ($errors->has('telefono'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('telefono') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-row">
                            <div class="col-md-4{{ $errors->has('fecha_fundacion') ? ' has-error' : '' }}">
                                <label for="fecha_fundacion">Fecha de Fundacion</label>
                                <input class="form-control text-right" id="fecha_fundacion" type="date" name="fecha_fundacion" value="{{ old('fecha_fundacion') }}" aria-describedby="emailHelp" placeholder="Ingrese la Fecha de Fundacion del Centro">
                                @if ($errors->has('fecha_fundacion'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('fecha_fundacion') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="col-md-8{{ $errors->has('nombre_director') ? ' has-error' : '' }}">
                                <label for="nombre_director">Nombre del Director</label>
                                <input class="form-control" id="nombre_director" type="text" name="nombre_director" value="{{ old('nombre_director') }}" aria-describedby="nameHelp" placeholder="Ingrese el Nombre del Director">
                                @if ($errors->has('nombre_director'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('nombre_director') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('direccion') ? ' has-error' : '' }}">
                        <label for="direccion">Direccion del Centro</label>
                        <input class="form-control" id="direccion" type="text" name="direccion" value="{{ old('direccion') }}" aria-describedby="nameHelp" placeholder="Ingrese la Direccion del Centro">
                        @if ($errors->has('direccion'))
                            <span class="help-block">
                            <strong>{{ $errors->first('direccion') }}</strong>
                        </span>
                        @endif
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">
                        Registrar Centro
                    </button>
                    {{--<a class="btn btn-primary btn-block" href="login.html">Register</a>--}}
                </form>
            </div>
        </div>
    </div>
@endsection


