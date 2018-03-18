<?php

namespace App\Http\Controllers;

use App\Adoptante;
use App\User;
use Illuminate\Http\Request;
use Validator;

class AdoptanteController extends Controller
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
            'telefono_fijo' => 'digits:7|numeric',
            'telefono_celular' => 'required|numeric|digits:8',
            'email' => 'required|string|email|max:255|unique:users',
            'ocupacion' => 'required|string|max:255',
            'direccion' => 'required|string|max:255',
        ]);
    }

    protected function validatorUpdate(array $data)
    {
        return Validator::make($data, [
            'telefono_fijo' => 'digits:7|numeric',
            'telefono_celular' => 'required|numeric|digits:8',
            'ocupacion' => 'required|string|max:255',
            'direccion' => 'required|string|max:255',
        ]);
    }

    public function index()
    {
        $adoptantes = Adoptante::with(['user'])->get();
        return view('adoptante.index', ['adoptantes' => $adoptantes]);
    }

    public function create()
    {
        $extenciones = array('LP', 'CB', 'SCZ', 'TR', 'OR', 'PT', 'SC', 'BI', 'PA');
        $estado_civil = array('Casado', 'Soltero', 'Viudo');
        return view('adoptante.create', ['extenciones' => $extenciones, 'estado_civil' => $estado_civil]);
    }

    public function store(Request $request)
    {
        $this->validator($request->all())->validate();
        $user = User::create([
            'ci' => $request['ci'],
            'ci_extencion' => $request['ci_extencion'],
            'nombres' => strtoupper($request['nombres']),
            'apellido_paterno' => strtoupper($request['apellido_paterno']),
            'apellido_materno' => strtoupper($request['apellido_materno']),
            'fecha_nacimiento' => $request['fecha_nacimiento'],
            'telefono_fijo' => $request['telefono_fijo'],
            'telefono_celular' => $request['telefono_celular'],
            'desabilitado' => True,
            'rol' => 'Adoptante',
            'email' => $request['email'],
            'password' => bcrypt('123456'),
        ]);
        Adoptante::create([
            'direccion' => $request['direccion'],
            'ocupacion' => $request['ocupacion'],
            'estado_civil' => $request['estado_civil'],
            'desabilitado' => $request['desabilitado'] == 'on' ? True : False,
            'user_id' => $user['id'],
        ]);
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
        $estado_civil = array('Casado', 'Soltero', 'Viudo');
        $adoptante = Adoptante::with(['user'])->find($id);
        return view('adoptante.edit', ['adoptante' => $adoptante, 'estado_civil' => $estado_civil]);
    }

    public function update(Request $request, $id)
    {
        $this->validatorUpdate($request->all())->validate();
        Adoptante::where('id', $id)
            ->update([
                'direccion' => $request['direccion'],
                'ocupacion' => $request['ocupacion'],
                'estado_civil' => $request['estado_civil'],
                'desabilitado' => $request['desabilitado'] == 'on' ? True : False,
            ]);
        $adoptante = Adoptante::find($id);
        User::where('id', $adoptante['user_id'])
            ->update([
                'telefono_fijo' => $request['telefono_fijo'],
                'telefono_celular' => $request['telefono_celular'],
            ]);
        $message['success'] = True;
        $message['success_message'] = 'Datos Actualizados Exitosamente';
        $estado_civil = array('Casado', 'Soltero', 'Viudo');
        $adoptante = Adoptante::with(['user'])->find($id);
        return view('adoptante.edit', ['adoptante' => $adoptante, 'estado_civil' => $estado_civil, 'message' => $message]);
    }

    public function destroy($id)
    {
        try {
            User::destroy($id);
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
