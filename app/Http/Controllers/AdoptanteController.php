<?php

namespace App\Http\Controllers;

use App\User;
use Validator;
use App\Adoptante;
use Illuminate\Http\Request;

class AdoptanteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $adoptantes = Adoptante::with(['user'])->get();
        return view('adoptante.index', ['adoptantes' => $adoptantes]);
    }

    public function create()
    {
        $extenciones = User::USUARIO_CI_EXT;
        $estado_civil = Adoptante::ADOPTANTE_ESTADO_CIVIL;
        return view('adoptante.create', ['extenciones' => $extenciones, 'estado_civil' => $estado_civil]);
    }

    public function store(Request $request)
    {
        $rules = [
            'ci' => 'required|numeric|digits_between:6,10|unique:users',
            'ci_extencion' => 'required|string|'.'in:' . implode(",",User::USUARIO_CI_EXT),
            'nombres' => 'required|string|max:20',
            'apellido_paterno' => 'required|string|max:20',
            'apellido_materno' => 'required|string|max:20',
            'telefono_fijo' => 'required|digits:7|numeric',
            'telefono_celular' => 'required|numeric|digits:8',
            'fecha_nacimiento' => 'required',
            'email' => 'required|string|email|max:30|unique:users',
            'ocupacion' => 'required|string|max:20',
            'direccion' => 'required|string|max:50',
            'genero' => 'required|string|'.'in:' . implode(",",User::USUARIO_GENERO),
        ];

        $this->validate($request, $rules);

        $campos_user = $request->all();
        $campos_user['habilitado'] = User::USUARIO_NO_HABILITADO;
        $campos_user['rol'] = User::USUARIO_ROLES['AD'];
        $campos_user['password'] = '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm';

        $user = User::create($campos_user);

        $campos_adoptante = $request->all();
        $campos_adoptante['habilitado'] = $request->has('habilitado') ? 1 : 0;
        $campos_adoptante['user_id'] = $user->id;

        Adoptante::create($campos_adoptante);

        $message['success'] = True;
        $message['success_message'] = 'Adoptate Registrado Exitosamente';
        $adoptantes = Adoptante::with(['user'])->get();
        return view('adoptante.index', ['adoptantes' => $adoptantes, 'message' => $message]);
    }

    public function show($id)
    {
        $adoptante = Adoptante::with(['user'])->find($id);
        return view('adoptante.show', ['adoptante' => $adoptante]);
    }

    public function edit($id)
    {
        $estado_civil = Adoptante::ADOPTANTE_ESTADO_CIVIL;
        $adoptante = Adoptante::with(['user'])->find($id);
        return view('adoptante.edit', ['adoptante' => $adoptante, 'estado_civil' => $estado_civil]);
    }

    public function update(Request $request, $id)
    {
        $adoptante = Adoptante::find($id);
        $reglas = [
            'telefono_fijo' => 'digits:7|numeric',
            'telefono_celular' => 'required|numeric|digits:8',
            'ocupacion' => 'required|string|max:20',
            'estado_civil' => 'required|string|'.'in:' . implode(",",Adoptante::ADOPTANTE_ESTADO_CIVIL),
            'direccion' => 'required|string|max:50',
        ];

        $this->validate($request, $reglas);

        if ($request->has('telefono_fijo') && $adoptante->user->telefono_fijo != $request->telefono_fijo) {
            $adoptante->user->telefono_fijo = $request->telefono_fijo;
        }
        if ($request->has('telefono_celular')  && $adoptante->user->telefono_celular != $request->telefono_celular) {
            $adoptante->user->telefono_celular = $request->telefono_celular;
        }
        if ($request->has('ocupacion')  && $adoptante->ocupacion != $request->ocupacion) {
            $adoptante->ocupacion = $request->ocupacion;
        }
        if ($request->has('estado_civil')  && $adoptante->estado_civil != $request->estado_civil) {
            $adoptante->estado_civil = $request->estado_civil;
        }
        if ($request->has('direccion')  && $adoptante->direccion != $request->direccion) {
            $adoptante->direccion = $request->direccion;
        }
        $adoptante->habilitado = $request->has('habilitado') ? 1 : 0;

        if ($adoptante->isClean() && $adoptante->user->isClean())
        {
            $message['warning'] = True;
            $message['warning_message'] = 'Se debe especificar al menos un valor diferente para actualizar';
        }
        else
        {
            if($adoptante->isDirty()){
                $adoptante->save();
            }
            if($adoptante->user->isDirty()){
                $adoptante->user->save();
            }
            $message['success'] = True;
            $message['success_message'] = 'Datos Actualizados Exitosamente';
        }

        $estado_civil = Adoptante::ADOPTANTE_ESTADO_CIVIL;
        return view('adoptante.edit', [
            'adoptante' => $adoptante,
            'estado_civil' => $estado_civil,
            'message' => $message
        ]);
    }

    public function destroy($id)
    {
        $adoptante = Adoptante::find($id);
        try {
            $adoptante->delete();
            $message['success'] = True;
            $message['success_message'] = 'Adoptante Eliminado Exitosamente';
        }
        catch (\Illuminate\Database\QueryException $e) {
            if($e->getCode() == "23000"){
                $message['error'] = True;
                $message['error_message'] = 'El Adoptante no puede ser Eliminado';
            }
        }
        $adoptantes = Adoptante::with(['user'])->get();
        return view('adoptante.index', ['adoptantes' => $adoptantes, 'message' => $message]);
    }
}
