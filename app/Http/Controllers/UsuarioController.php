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

    public function index()
    {
        $usuarios = User::whereNotIn('rol', array('Administrador', 'Adoptante'))->get();
        return view('usuario.index', ['usuarios' => $usuarios]);
    }

    public function create()
    {
        $roles = User::USUARIO_ROLES;;
        $extenciones = User::USUARIO_CI_EXT;
        return view('usuario.create', ['roles' => $roles, 'extenciones' => $extenciones]);
    }

    public function store(Request $request)
    {
        $rules = [
            'ci' => 'required|numeric|digits_between:6,10|unique:users',
            'ci_extencion' => 'required|string|'.'in:' . implode(",",User::USUARIO_CI_EXT),
            'email' => 'required|string|email|max:20|unique:users',
            'nombres' => 'required|string|max:20',
            'apellido_paterno' => 'required|string|max:20',
            'apellido_materno' => 'required|string|max:20',
            'fecha_nacimiento' => 'required',
            'genero' => 'required|string|'.'in:' . implode(",",User::USUARIO_GENERO),
            'telefono_fijo' => 'required|digits:7|numeric',
            'telefono_celular' => 'required|numeric|digits:8',
            'password' => 'required|string|min:6|confirmed',
            'rol' => 'in:' . implode(",",User::USUARIO_ROLES),
        ];

        $this->validate($request, $rules);

        $campos = $request->all();
        $campos['password'] = bcrypt($request->password);
        $campos['habilitado'] = User::USUARIO_NO_HABILITADO;
        $campos['admin'] = User::USUARIO_REGULAR;

        User::create($campos);

        $message['success'] = True;
        $message['success_message'] = 'Usuario Registrado Exitosamente';

        $usuarios = User::whereNotIn('rol', array('Administrador', 'Adoptante'))->get();
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
        $user = User::find($id);
        $reglas = [
            'nombres' => 'required|string|max:255',
            'apellido_paterno' => 'required|string|max:255',
            'apellido_materno' => 'required|string|max:255',
            'telefono_fijo' => 'required|digits:7|numeric',
            'telefono_celular' => 'required|numeric|digits:8',
            'admin' => 'in:' . User::USUARIO_ADMINISTRADOR . ',' . User::USUARIO_REGULAR,
            'habilitado' => 'in:' . User::USUARIO_HABILITADO . ',' . User::USUARIO_NO_HABILITADO,
        ];

        $this->validate($request, $reglas);

        if ($request->has('nombres')) {
            $user->nombres = $request->nombres;
        }
        if ($request->has('apellido_paterno')) {
            $user->apellido_paterno = $request->apellido_paterno;
        }
        if ($request->has('apellido_materno')) {
            $user->apellido_materno = $request->apellido_materno;
        }
        if ($request->has('telefono_fijo')) {
            $user->telefono_fijo = $request->telefono_fijo;
        }
        if ($request->has('telefono_celular')) {
            $user->telefono_celular = $request->telefono_celular;
        }
        if ($request->has('admin')) {
            $user->admin = $request->admin;
        }
        if ($request->has('habilitado')) {
            $user->habilitado = $request->habilitado;
        }
        if (!$user->isDirty()) {
            $message['warning'] = True;
            $message['warning_message'] = 'Se debe especificar al menos un valor diferente para actualizar';
            return view('usuario.edit', ['usuario' => $user, 'message' => $message]);
        }
        $user->save();
        $message['success'] = True;
        $message['success_message'] = 'Datos Actualizados Exitosamente';
        return view('usuario.edit', ['usuario' => $user, 'message' => $message]);
    }

    public function destroy($id)
    {
        $user = User::find($id);
        try {
            $user->delete();
            $message['success'] = True;
            $message['success_message'] = 'Usuario Eliminado Exitosamente';
        }
        catch (\Illuminate\Database\QueryException $e) {
            if($e->getCode() == "23000"){
                $message['error'] = True;
                $message['error_message'] = 'El Usuario no puede ser Eliminado';
            }
        }
        $usuarios = User::whereNotIn('rol', array('Administrador', 'Adoptante'))->get();
        return view('usuario.index', ['usuarios' => $usuarios, 'message' => $message]);
    }

    public function user_adoptantes(){
        $products=User::select(
            'id',
            'ci',
            'ci_extencion',
            'nombres',
            'apellido_paterno',
            'apellido_materno'
        )->where('rol', 'Adoptante')->get();
        return response()->json($products);
    }
}
