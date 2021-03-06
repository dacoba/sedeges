<?php

namespace App\Http\Controllers;

use DB;
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

    protected function validatorUpdate(array $data)
    {
        return Validator::make($data, [
            'ci' => 'numeric|digits_between:6,10|unique:users',
            'ci_extencion' => 'string',
            'centro_id' => 'required|exists:centros,id',
            'fecha_ingreso' => 'required',
            'descripcion' => 'required',
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
        $rules = [
            'ci' => 'numeric|digits_between:6,10|unique:users',
            'ci_extencion' => 'string',
            'nombre' => 'required|string|max:255',
            'fecha_nacimiento' => 'required|date|after:-18 years|before:now',
            'fecha_ingreso' => 'required|after:fecha_nacimiento|before:now',
            'descripcion' => 'required',
            'centro_id' => 'required|exists:centros,id',
        ];
        $this->validate($request, $rules);

        $centro = Centro::find($request->centro_id);
        $infantes = Infante::get();
        $capacidad = $centro->capacidad;
        $cantidad_infantes = $centro->infantes->count();
        if((int)$capacidad > (int)$cantidad_infantes) {
            $values = $request->all();
            $values['nombre'] = strtoupper($request['nombre']);
            $values['habilitado'] = $request->habilitado == 'on' ? True : False;
            $values['adoptado'] = $request->adoptado == 'on' ? True : False;
            $infante = Infante::create($values);
            $message['success'] = True;
            $message['success_message'] = 'Infante Registrado Exitosamente';
        }else{
            $message['error'] = True;
            $message['error_message'] = 'El centro ya alcanzo el numero limite de infantes';
        }
        return view('infante.index', ['infantes' => $infantes, 'message' => $message]);
    }

    public function show(Infante $infante)
    {
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
    public function json_infantes(){
        $products=Infante::join('centros', 'infantes.centro_id', '=', 'centros.id')->select(
            'infantes.id as id',
            'ci',
            'ci_extencion',
            'nombre',
            DB::raw('TIMESTAMPDIFF(YEAR,fecha_nacimiento,CURDATE()) AS age'),
            'centros.nombre_centro'
        )->where('habilitado', true)->where('adoptado', false)->get();
        return response()->json($products);
    }
}
