<?php

namespace App\Http\Controllers;

use App\Centro;
use Illuminate\Http\Request;
use Validator;

class CentroController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'nombre_centro' => 'required|string|max:255',
            'capacidad' => 'required|integer|min:1|max:100',
            'direccion' => 'required|string|max:255',
            'nombre_director' => 'required|string|max:255',
            'telefono' => 'required|digits:7|numeric',
        ]);
    }
    protected function validatorUpdate(array $data)
    {
        return Validator::make($data, [
            'direccion' => 'required|string|max:255',
            'capacidad' => 'required|integer|min:1|max:100',
            'nombre_director' => 'required|string|max:255',
            'telefono' => 'required|digits:7|numeric',
        ]);
    }

    public function index()
    {
        $centros = Centro::get();
        return view('centro.index', ['centros' => $centros]);
    }

    public function create()
    {
        return view('centro.create');
    }

    public function store(Request $request)
    {
        $this->validator($request->all())->validate();
        Centro::create([
            'nombre_centro' => strtoupper($request['nombre_centro']),
            'capacidad' => $request['capacidad'],
            'direccion' => $request['direccion'],
            'nombre_director' => strtoupper($request['nombre_director']),
            'telefono' => $request['telefono'],
            'fecha_fundacion' => $request['fecha_fundacion'],
        ]);
        $message['success'] = True;
        $message['success_message'] = 'Centro Registrado Exitosamente';
        $centros = Centro::get();
        return view('centro.index', ['centros' => $centros, 'message' => $message]);
    }

    public function show($id)
    {
        $centro = Centro::find($id);
        return view('centro.show', ['centro' => $centro]);
    }

    public function edit($id)
    {
        $centro = Centro::find($id);
        return view('centro.edit', ['centro' => $centro]);
    }

    public function update(Request $request, $id)
    {
        $this->validatorUpdate($request->all())->validate();
        Centro::where('id', $id)
            ->update([
                'capacidad' => $request['capacidad'],
                'direccion' => $request['direccion'],
                'nombre_director' => strtoupper($request['nombre_director']),
                'telefono' => $request['telefono'],
            ]);
        $message['success'] = True;
        $message['success_message'] = 'Datos Actualizados Exitosamente';
        $centro = Centro::find($id);
        return view('centro.edit', ['centro' => $centro, 'message' => $message]);
    }

    public function destroy($id)
    {
        try {
            Centro::destroy($id);
            $message['success'] = True;
            $message['success_message'] = 'Centro Eliminado Exitosamente';
        }
        catch (\Illuminate\Database\QueryException $e) {
            if($e->getCode() == "23000"){
                $message['error'] = True;
                $message['error_message'] = 'El Centro no puede ser Eliminado';
            }
        }
        $centros = Centro::get();
        return view('centro.index', ['centros' => $centros, 'message' => $message]);
    }
}
