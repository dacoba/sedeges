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
        $rules = [
            'nombre_centro' => 'required|string|max:255',
            'direccion' => 'required|string|max:255',
            'nombre_director' => 'required|string|max:255',
            'telefono' => 'required|digits:7|numeric'
        ];

        $this->validate($request, $rules);

        Centro::create($request->all());

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
        $centro = Centro::find($id);
        $reglas = [
            'direccion' => 'required|string|max:255',
            'nombre_director' => 'required|string|max:255',
            'telefono' => 'required|digits:7|numeric',
        ];

        $this->validate($request, $reglas);

        if ($request->has('direccion')) {
            $centro->direccion = $request->direccion;
        }
        if ($request->has('nombre_director')) {
            $centro->nombre_director = $request->nombre_director;
        }
        if ($request->has('telefono')) {
            $centro->telefono = $request->telefono;
        }

        if (!$centro->isDirty()) {
            $message['warning'] = True;
            $message['warning_message'] = 'Se debe especificar al menos un valor diferente para actualizar';
            return view('centro.edit', ['centro' => $centro, 'message' => $message]);
        }

        $centro->save();

        $message['success'] = True;
        $message['success_message'] = 'Datos Actualizados Exitosamente';
        return view('centro.edit', ['centro' => $centro, 'message' => $message]);
    }

    public function destroy($id)
    {
        $centro = Centro::find($id);
        try {
            $centro->delete();
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
