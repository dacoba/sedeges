<?php

namespace App\Http\Controllers;

use DB;
use App\User;
use Validator;
use App\Centro;
use App\Infante;
use Illuminate\Http\Request;

class InfanteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $infantes = Infante::with(['centro'])->get();
        return view('infante.index', ['infantes' => $infantes]);
    }

    public function create()
    {
        $centros = Centro::get();
        $extenciones = User::USUARIO_CI_EXT;
        return view('infante.create', ['centros' => $centros, 'extenciones' => $extenciones]);
    }

    public function store(Request $request)
    {
        $rules = [
            'ci' => 'numeric|digits_between:6,10|unique:infantes',
            'ci_extencion' => 'string',
            'nombre' => 'required|string|max:255',
            'fecha_nacimiento' => 'required',
            'fecha_ingreso' => 'required',
            'descripcion' => 'required',
        ];

        $this->validate($request, $rules);

        $campos = $request->all();
        $centro = Centro::findOrFail($request->centro_id);
        $campos['habilitado'] = $request->has('habilitado') ? 1 : 0;
        $campos['adoptado'] = $request->has('adoptado') ? 1 : 0;
        $campos['centro_id'] = $centro->id;

        Infante::create($campos);

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
        $extenciones = User::USUARIO_CI_EXT;
        return view('infante.edit', ['centros' => $centros, 'extenciones' => $extenciones, 'infante' => $infante]);
    }

    public function update(Request $request, $id)
    {
        $infante = Infante::find($id);

        $reglas = [
            'ci' => 'numeric|digits_between:6,10|unique:infantes',
            'ci_extencion' => 'string',
            'nombre' => 'required|string',
            'centro_id' => 'required',
            'fecha_ingreso' => 'required',
            'descripcion' => 'required',
        ];

        $this->validate($request, $reglas);

        if ($request->has('ci') && $infante->ci != $request->ci) {
            $infante->ci = $request->ci;
        }
        if ($request->has('ci_extencion') && $infante->ci_extencion != $request->ci_extencion) {
            $infante->ci_extencion = $request->ci_extencion;
        }
        if ($request->has('nombre') && $infante->nombre != $request->nombre) {
            $infante->nombre = $request->nombre;
        }
        if ($request->has('descripcion') && $infante->descripcion != $request->descripcion) {
            $infante->descripcion = $request->descripcion;
        }
        if ($request->has('centro_id') && $infante->centro_id != $request->centro_id) {
            $centro = Centro::findOrFail($request->centro_id);
            $infante->centro_id = $centro->id;
            $infante->fecha_ingreso = $request->fecha_ingreso;
        }
        if ($request->has('descripcion') && $infante->descripcion != $request->descripcion) {
            $infante->descripcion = $request->descripcion;
        }
        $infante->habilitado = $request->has('habilitado') ? 1 : 0;
        $infante->adoptado = $request->has('adoptado') ? 1 : 0;

        $centros = Centro::get();
        $extenciones = User::USUARIO_CI_EXT;

        if (!$infante->isDirty()) {
            $message['warning'] = True;
            $message['warning_message'] = 'Se debe especificar al menos un valor diferente para actualizar';
            return view('infante.edit', [
                'centros' => $centros,
                'extenciones' => $extenciones,
                'infante' => $infante,
                'message' => $message
            ]);
        }

        $infante->save();

        $message['success'] = True;
        $message['success_message'] = 'Datos Actualizados Exitosamente';
        return view('infante.edit', [
            'centros' => $centros,
            'extenciones' => $extenciones,
            'infante' => $infante,
            'message' => $message
        ]);
    }

    public function destroy($id)
    {
        $infante = Infante::find($id);
        try {
            $infante->delete();
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
