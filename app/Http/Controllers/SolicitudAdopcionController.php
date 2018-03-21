<?php

namespace App\Http\Controllers;

use App\User;
use App\SolicitudAdopcion;
use App\AdopcionDocument;
use App\Adoptante;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

class SolicitudAdopcionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    protected function getDocumentsTypes()
    {
        return array(
            1 => "Carta Solicitud",
            2 => "Certificado de Antecedentes",
            3 => "Informe Antecedentes",
            4 => "Verificacion Domiciliaria",
            5 => "Certificado Estado Civil"
        );
    }

    protected function getDocumentsTypesStored($id)
    {
        $request = AdopcionDocument::select('type')->where('solicitud_id', $id)->get();
        $response = [];
        foreach ($request as $item){
            $response[] = $item['type'];
        }
        return $response;
    }

    protected function getEstadosToText()
    {
        return array(
            0 => "Registro",
            1 => "Requisitos",
            2 => "Trabajo Social",
            101 => "Requisitos Rechazado"
        );
    }

    protected function getSolicitudes()
    {
        if (Auth::user()->rol == "Secretaria"){
            return SolicitudAdopcion::with(['adoptante', 'adoptante.user'])->where('estado', 0)->get();
        }elseif (Auth::user()->rol == "Coordinador"){
            return SolicitudAdopcion::with(['adoptante', 'adoptante.user'])->whereIn('estado', array(1))->get();
        }elseif (Auth::user()->rol == "Trabajador Social"){
            return SolicitudAdopcion::with(['adoptante', 'adoptante.user'])->whereIn('estado', array(2))->get();
        }else{
            return SolicitudAdopcion::with(['adoptante', 'adoptante.user'])->get();
        }
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'adoptante' => 'required',
            'infante_genero' => 'required',
            'infante_edad_desde' => 'required',
            'infante_edad_hasta' => 'required',
            'doc_file' => 'required',
        ]);
    }
    protected function validatorVerificacionRequisitos(array $data)
    {
        return Validator::make($data, [
            'observacion_requisitos' => 'required',
        ]);
    }

    protected function validatorDocument(array $data)
    {
        return Validator::make($data, [
            'doc_file' => 'required',
        ]);
    }

    public function index()
    {
        $estados_solicitud = $this->getEstadosToText();
        $solicitudes = $this->getSolicitudes();
        return view('solicitud.index', ['solicitudes' => $solicitudes, 'estados_solicitud' => $estados_solicitud]);
    }

    public function create()
    {
        $DocumentsTypes = $this->getDocumentsTypes();
        return view('solicitud.create', ['DocumentsTypes' => $DocumentsTypes]);
    }

    public function store(Request $request)
    {
        $this->validator($request->all())->validate();
        $this->validatorDocument($request->all())->validate();
        $adoptante_user = User::find($request['adoptante_user_id']);
        $SolicitudAdopcion = SolicitudAdopcion::where('adoptante_id', $adoptante_user['adoptante']['id'])->whereNotIn('estado', array(100))->get();
        if($SolicitudAdopcion->count() or $adoptante_user['adoptante']['desabilitado']){
            $estados_solicitud = $this->getEstadosToText();
            $solicitudes = $this->getSolicitudes();
            $message['error'] = True;
            $message['error_message'] = 'El Adoptante ya se encuentra en un proceso de Adopcion';
            if($adoptante_user['adoptante']['desabilitado']){
                $message['error_message'] = 'El Adoptante esta desabilitado para realizar procesos de Adopcion';
            }
            return view('solicitud.index', [
                'solicitudes' => $solicitudes,
                'estados_solicitud' => $estados_solicitud,
                'message' => $message
            ]);
        }
        if(Input::hasfile('doc_file')) {
            echo "1";
            $solicitud = SolicitudAdopcion::create([
                'infante_genero' => $request['infante_genero'],
                'infante_edad_desde' => $request['infante_edad_desde'],
                'infante_edad_hasta' => $request['infante_edad_hasta'],
                'adoptante_id' => $adoptante_user['adoptante']['id'],
                'estado' => 0,
                'observacion_registro' => $request['observacion_registro'],
            ]);
            echo "2";
            $file = Input::file('doc_file');
            AdopcionDocument::create([
                'type' => $request['doc_type'],
                'name' => $file->getClientOriginalName(),
                'size' => $file->getClientSize(),
                'mime' => $file->getClientMimeType(),
                'file' => base64_encode(file_get_contents($file->getRealPath())),
                'solicitud_id' => $solicitud['id'],
            ]);
            echo "3";
        }

//        $message['success'] = True;
//        $message['success_message'] = 'Solicitud de Adopcion Registrado Exitosamente';
        $DocumentsTypes = $this->getDocumentsTypes();
        $DocumentsTypesStored = $this->getDocumentsTypesStored($solicitud['id']);
        $documents = AdopcionDocument::select('id', 'name', 'type', 'mime')->where('solicitud_id', $solicitud['id'])->get();
        return view('solicitud.edit', [
            'solicitud' => $solicitud,
            'DocumentsTypes' => $DocumentsTypes,
            'DocumentsTypesStored' => $DocumentsTypesStored,
            'documents' => $documents
        ]);
    }

    public function show(SolicitudAdopcion $solicitudAdopcion)
    {
        //
    }

    public function edit($id)
    {
        $solicitud = SolicitudAdopcion::with(['adoptante', 'adoptante.user'])->find($id);
        $DocumentsTypes = $this->getDocumentsTypes();
        $DocumentsTypesStored = $this->getDocumentsTypesStored($id);
        $documents = AdopcionDocument::select('id', 'name', 'type', 'mime')->where('solicitud_id', $id)->get();
        if($solicitud['estado'] == 0 and in_array(Auth::user()->rol , array("Secretaria", "Administrador"))){
            return view('solicitud.edit', [
                'solicitud' => $solicitud,
                'DocumentsTypes' => $DocumentsTypes,
                'DocumentsTypesStored' => $DocumentsTypesStored,
                'documents' => $documents
            ]);
        }
        return view('solicitud.edit', [
            'solicitud' => $solicitud,
            'DocumentsTypes' => $DocumentsTypes,
            'DocumentsTypesStored' => $DocumentsTypesStored,
            'documents' => $documents
        ]);
    }

    public function update(Request $request, $id)
    {
        $DocumentsTypes = $this->getDocumentsTypes();
        $estados_solicitud = $this->getEstadosToText();
        $solicitud = SolicitudAdopcion::with(['adoptante', 'adoptante.user'])->find($id);
        if($solicitud['estado'] == 0 and in_array(Auth::user()->rol , array("Secretaria", "Administrador"))){

            $DocumentsTypesStored = $this->getDocumentsTypesStored($id);
            if(count($DocumentsTypes) == count($DocumentsTypesStored)){
                $solicitud['estado'] = 1;
            }

            if(Input::hasfile('doc_file')){
                $this->validatorDocument($request->all())->validate();
                $file = Input::file('doc_file');
                AdopcionDocument::create([
                    'type' => $request['doc_type'],
                    'name' => $file->getClientOriginalName(),
                    'size' => $file->getClientSize(),
                    'mime' => $file->getClientMimeType(),
                    'file' => base64_encode(file_get_contents($file->getRealPath())),
                    'solicitud_id' => $id,
                ]);
            }

            SolicitudAdopcion::where('id', $id)
                ->update([
                    'estado' => $solicitud['estado'],
                    'observacion_registro' => $request['observacion_registro'],
                ]);

            if ($solicitud['estado'] == 1) {
                $message['success'] = True;
                $message['success_message'] = 'Solicitud de Adopcion Confirmada Exitosamente';
                $solicitudes = $this->getSolicitudes();
                return view('solicitud.index', [
                    'solicitudes' => $solicitudes,
                    'estados_solicitud' => $estados_solicitud,
                    'message' => $message
                ]);
            }
        }elseif ($solicitud['estado'] == 1 and in_array(Auth::user()->rol , array("Coordinador", "Administrador"))){
            if (isset($request['verificacion_requisitos'])) {
                $verificacion_requisitos = $request['verificacion_requisitos'] == 'true' ? True : False;
                if($verificacion_requisitos){
                    $solicitud['estado'] = 2;
                    $message['success'] = True;
                    $message['success_message'] = 'Solicitud de Adopcion Confirmada Exitosamente';
                }else{
                    $this->validatorVerificacionRequisitos($request->all())->validate();
                    $solicitud['estado'] = 101;
                    $message['error'] = True;
                    $message['error_message'] = 'La Solicitud de Adopcion ha sido Rechazada';
                }
            }
            SolicitudAdopcion::where('id', $id)
                ->update([
                    'estado' => $solicitud['estado'],
                    'observacion_requisitos' => $request['observacion_requisitos'],
                    'verificacion_requisitos' => $verificacion_requisitos,
                ]);
            $solicitudes = $this->getSolicitudes();
            return view('solicitud.index', ['solicitudes' => $solicitudes, 'estados_solicitud' => $estados_solicitud, 'message' => $message]);
        }
        $solicitud = SolicitudAdopcion::with(['adoptante', 'adoptante.user'])->find($id);
        $documents = AdopcionDocument::select('id', 'name', 'type', 'mime')->where('solicitud_id', $id)->get();
        $DocumentsTypesStored = $this->getDocumentsTypesStored($id);
        return view('solicitud.edit', [
            'solicitud' => $solicitud,
            'DocumentsTypes' => $DocumentsTypes,
            'DocumentsTypesStored' => $DocumentsTypesStored,
            'documents' => $documents
        ]);
    }

    public function destroy(SolicitudAdopcion $solicitudAdopcion)
    {
        //
    }
}
