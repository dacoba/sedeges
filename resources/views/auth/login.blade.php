@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card card-login mx-auto mt-5">
        <div class="card-header">Iniciar Sesion</div>
        <div class="card-body">
            <form class="form-horizontal" method="POST" action="{{ route('login') }}">
                {{ csrf_field() }}
                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <label for="exampleInputEmail1">Direccion de Email</label>
                    <input class="form-control" id="email" aria-describedby="emailHelp" placeholder="Ingrese su direccion de email" name="email" value="{{ old('email') }}">
                    @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                    <label for="exampleInputPassword1">Contraseña</label>
                    <input class="form-control" id="password" type="password" placeholder="Ingrese su Contraseña" name="password">
                    @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>
                {{--<a class="btn btn-primary btn-block" href="index.html">Login</a>--}}
                <button type="submit" class="btn btn-primary btn-block">
                    Iniciar Sesion
                </button>
            </form>
        </div>
    </div>
</div>
<style>
    footer{
        position: fixed;
        right: 0;
        bottom: 0;
        left: 0;
    }
</style>
@endsection
