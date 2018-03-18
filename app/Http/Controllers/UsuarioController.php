<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Validator;

class UsuarioController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'ci' => 'required|numeric|digits_between:6,10|unique:users',
            'ci_extencion' => 'required|string',
            'nombres' => 'required|string|max:255',
            'apellido_paterno' => 'required|string|max:255',
            'apellido_materno' => 'required|string|max:255',
            'telefono_fijo' => 'required|digits:7|numeric',
            'telefono_celular' => 'required|numeric|digits:8',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }
    protected function validatorUpdate(array $data)
    {
        return Validator::make($data, [
            'nombres' => 'required|string|max:255',
            'apellido_paterno' => 'required|string|max:255',
            'apellido_materno' => 'required|string|max:255',
            'telefono_fijo' => 'required|digits:7|numeric',
            'telefono_celular' => 'required|numeric|digits:8',
        ]);
    }

    public function index()
    {
        $usuarios = User::where('rol', '<>', 'Administrador')->get();
        return view('usuario.index', ['usuarios' => $usuarios]);
    }

    public function create()
    {
        $roles = array('Administrador', 'Secretaria', 'Coordinador', 'Trabajador Social', 'Psicologo', 'Doctor', 'Abogado', 'Adoptante');
        $extenciones = array('LP', 'CB', 'SCZ', 'TR', 'OR', 'PT', 'SC', 'BI', 'PA');
        return view('usuario.create', ['roles' => $roles, 'extenciones' => $extenciones]);
    }

    public function store(Request $request)
    {
        $this->validator($request->all())->validate();
        User::create([
            'ci' => $request['ci'],
            'ci_extencion' => $request['ci_extencion'],
            'nombres' => strtoupper($request['nombres']),
            'apellido_paterno' => strtoupper($request['apellido_paterno']),
            'apellido_materno' => strtoupper($request['apellido_materno']),
            'genero' => $request['genero'],
            'fecha_nacimiento' => $request['fecha_nacimiento'],
            'telefono_fijo' => $request['telefono_fijo'],
            'telefono_celular' => $request['telefono_celular'],
            'desabilitado' => False,
            'rol' => $request['rol'],
            'email' => $request['email'],
            'password' => bcrypt($request['password']),
        ]);
        $message['success'] = True;
        $message['success_message'] = 'Usuario Registrado Exitosamente';
        $usuarios = User::where('rol', '<>', 'Administrador')->get();
        return view('usuario.index', ['usuarios' => $usuarios, 'message' => $message]);
    }

    public function show($id)
    {
        $usuario = User::find($id);
        return view('usuario.show', ['usuario' => $usuario]);
    }

    public function edit($id)
    {
        $usuario = User::find($id);
        return view('usuario.edit', ['usuario' => $usuario]);
    }

    public function update(Request $request, $id)
    {
        $this->validatorUpdate($request->all())->validate();
        User::where('id', $id)
            ->update([
                'nombres' => strtoupper($request['nombres']),
                'apellido_paterno' => strtoupper($request['apellido_paterno']),
                'apellido_materno' => strtoupper($request['apellido_materno']),
                'telefono_fijo' => $request['telefono_fijo'],
                'telefono_celular' => $request['telefono_celular'],
            ]);
        $message['success'] = True;
        $message['success_message'] = 'Datos Actualizados Exitosamente';
        $usuario = User::find($id);
        return view('usuario.edit', ['usuario' => $usuario, 'message' => $message]);
    }

    public function destroy($id)
    {
        try {
            User::destroy($id);
            $message['success'] = True;
            $message['success_message'] = 'Usuario Eliminado Exitosamente';
        }
        catch (\Illuminate\Database\QueryException $e) {
            if($e->getCode() == "23000"){
                $message['error'] = True;
                $message['error_message'] = 'El Usuario no puede ser Eliminado';
            }
        }
        $usuarios = User::where('rol', '<>', 'Administrador')->get();
        return view('usuario.index', ['usuarios' => $usuarios, 'message' => $message]);
    }
}
