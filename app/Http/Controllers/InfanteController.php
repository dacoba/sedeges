<?php

namespace App\Http\Controllers;

use App\Infante;
use App\Centro;
use Illuminate\Http\Request;
use Validator;

class InfanteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'ci' => 'numeric|digits_between:6,10|unique:users',
            'ci_extencion' => 'string',
            'nombre' => 'required|string|max:255',
            'fecha_nacimiento' => 'required',
            'fecha_ingreso' => 'required',
            'descripcion' => 'required|string|max:255',
        ]);
    }

    protected function validatorUpdate(array $data)
    {
        return Validator::make($data, [
            'ci' => 'numeric|digits_between:6,10|unique:users',
            'ci_extencion' => 'string',
            'centro_id' => 'required',
            'fecha_ingreso' => 'required',
            'descripcion' => 'required|string|max:255',
        ]);
    }

    public function index()
    {
        $infantes = Infante::with(['centro'])->get();
        return view('infante.index', ['infantes' => $infantes]);
    }

    public function create()
    {
        $centros = Centro::get();
        $extenciones = array('LP', 'CB', 'SCZ', 'TR', 'OR', 'PT', 'SC', 'BI', 'PA');
        return view('infante.create', ['centros' => $centros, 'extenciones' => $extenciones]);
    }

    public function store(Request $request)
    {
        $this->validator($request->all())->validate();
        Infante::create([
            'ci' => $request['ci'],
            'ci_extencion' => $request['ci_extencion'],
            'nombre' => strtoupper($request['nombre']),
            'genero' => $request['genero'],
            'fecha_nacimiento' => $request['fecha_nacimiento'],
            'fecha_ingreso' => $request['fecha_ingreso'],
            'descripcion' => $request['descripcion'],
            'habilitado' => $request['habilitado'] == 'on' ? True : False,
            'adoptado' => $request['adoptado'] == 'on' ? True : False,
            'centro_id' => $request['centro_id'],
        ]);
        $message['success'] = True;
        $message['success_message'] = 'Infante Registrado Exitosamente';
        $infantes = Infante::get();
        return view('infante.index', ['infantes' => $infantes, 'message' => $message]);
    }

    public function show($id)
    {
        $infante = Infante::with(['centro'])->find($id);
        return view('infante.show', ['infante' => $infante]);
    }

    public function edit($id)
    {
        $centros = Centro::get();
        $infante = Infante::with(['centro'])->find($id);
        $extenciones = array('LP', 'CB', 'SCZ', 'TR', 'OR', 'PT', 'SC', 'BI', 'PA');
        return view('infante.edit', ['centros' => $centros, 'extenciones' => $extenciones, 'infante' => $infante]);
    }

    public function update(Request $request, $id)
    {
        $this->validatorUpdate($request->all())->validate();
        Infante::where('id', $id)
            ->update([
                'ci' => $request['ci'],
                'ci_extencion' => $request['ci_extencion'],
                'descripcion' => $request['descripcion'],
                'habilitado' => $request['habilitado'] == 'on' ? True : False,
                'adoptado' => $request['adoptado'] == 'on' ? True : False,
                'centro_id' => $request['centro_id'],
            ]);
        $message['success'] = True;
        $message['success_message'] = 'Datos Actualizados Exitosamente';
        $centros = Centro::get();
        $infante = Infante::with(['centro'])->find($id);
        $extenciones = array('LP', 'CB', 'SCZ', 'TR', 'OR', 'PT', 'SC', 'BI', 'PA');
        return view('infante.edit', ['centros' => $centros, 'extenciones' => $extenciones, 'infante' => $infante, 'message' => $message]);
    }

    public function destroy($id)
    {
        try {
            Infante::destroy($id);
            $message['success'] = True;
            $message['success_message'] = 'Infante Eliminado Exitosamente';
        }
        catch (\Illuminate\Database\QueryException $e) {
            if($e->getCode() == "23000"){
                $message['error'] = True;
                $message['error_message'] = 'El Infante no puede ser Eliminado';
            }
        }
        $infantes = Infante::get();
        return view('infante.index', ['infantes' => $infantes, 'message' => $message]);
    }
}
