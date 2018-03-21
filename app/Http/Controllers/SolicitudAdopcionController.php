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
        ]);
    }
    protected function validatorConfirm(array $data)
    {
        return Validator::make($data, [
            'carta_solicitud' => 'accepted',
            'certificado_antecedentes' => 'accepted',
            'informe_antecedentes' => 'accepted',
            'verificacion_domiciliaria' => 'accepted',
            'certificado_estadocivil' => 'accepted',
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
            'doc_file' => 'mimes:doc,docx,pdf,jpg,png',
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
        $adoptantes = Adoptante::with(['user'])->get();
        return view('solicitud.create', ['adoptantes' => $adoptantes]);
    }

    public function store(Request $request)
    {
        $this->validator($request->all())->validate();
        $estado = 0;
        if (isset($request['verificacion_registro']) && $request['verificacion_registro'] == "true") {
            $this->validatorConfirm($request->all())->validate();
            $estado = 1;
        }
        $adoptante_user = User::find($request['adoptante_user_id']);
        SolicitudAdopcion::create([
            'infante_genero' => $request['infante_genero'],
            'infante_edad_desde' => $request['infante_edad_desde'],
            'infante_edad_hasta' => $request['infante_edad_hasta'],
            'adoptante_id' => $adoptante_user['adoptante']['id'],
            'estado' => $estado,
            'carta_solicitud' => $request['carta_solicitud'] == 'on' ? True : False,
            'certificado_antecedentes' => $request['certificado_antecedentes'] == 'on' ? True : False,
            'informe_antecedentes' => $request['informe_antecedentes'] == 'on' ? True : False,
            'verificacion_domiciliaria' => $request['verificacion_domiciliaria'] == 'on' ? True : False,
            'certificado_estadocivil' => $request['certificado_estadocivil'] == 'on' ? True : False,
            'observacion_registro' => $request['observacion_registro'],
            'verificacion_registro' => $request['verificacion_registro'],
        ]);
        $message['success'] = True;
        $message['success_message'] = 'Solicitud de Adopcion Registrado Exitosamente';
        $solicitudes = $this->getSolicitudes();
        $estados_solicitud = $this->getEstadosToText();
        return view('solicitud.index', ['solicitudes' => $solicitudes, 'estados_solicitud' => $estados_solicitud, 'message' => $message]);
    }

    public function show(SolicitudAdopcion $solicitudAdopcion)
    {
        //
    }

    public function edit($id)
    {
        $estados_solicitud = $this->getEstadosToText();
        $solicitud = SolicitudAdopcion::with(['adoptante', 'adoptante.user'])->find($id);
        $doc_registro = $this->getDocumentsTypes();
        $documents = AdopcionDocument::select('id', 'name', 'type', 'mime')->where('solicitud_id', $id)->get();
        if($solicitud['estado'] == 0 and Auth::user()->rol == 'Secretaria'){
            return view('solicitud.edit', ['solicitud' => $solicitud, 'estados_solicitud' => $estados_solicitud, 'doc_registro' => $doc_registro, 'documents' => $documents]);
        }
        return view('solicitud.edit', ['solicitud' => $solicitud, 'estados_solicitud' => $estados_solicitud, 'doc_registro' => $doc_registro, 'documents' => $documents]);
    }

    public function update(Request $request, $id)
    {
        $estados_solicitud = $this->getEstadosToText();
        $solicitud = SolicitudAdopcion::with(['adoptante', 'adoptante.user'])->find($id);
        if($solicitud['estado'] == 0 and in_array(Auth::user()->rol , array("Secretaria", "Administrador"))){
            if (isset($request['verificacion_registro'])) {
                $verificacion_registro = $request['verificacion_registro'] == 'true' ? True : False;
                if($verificacion_registro){
                    $this->validatorConfirm($request->all())->validate();
                    $solicitud['estado'] = 1;
                    $message['success'] = True;
                    $message['success_message'] = 'Solicitud de Adopcion Confirmada Exitosamente';
                }
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
                    'carta_solicitud' => $request['carta_solicitud'] == 'on' ? True : False,
                    'certificado_antecedentes' => $request['certificado_antecedentes'] == 'on' ? True : False,
                    'informe_antecedentes' => $request['informe_antecedentes'] == 'on' ? True : False,
                    'verificacion_domiciliaria' => $request['verificacion_domiciliaria'] == 'on' ? True : False,
                    'certificado_estadocivil' => $request['certificado_estadocivil'] == 'on' ? True : False,
                    'estado' => $solicitud['estado'],
                    'observacion_registro' => $request['observacion_registro'],
                    'verificacion_registro' => $verificacion_registro,
                ]);
            if ($solicitud['estado'] == 1) {
                $solicitudes = $this->getSolicitudes();
                return view('solicitud.index', ['solicitudes' => $solicitudes, 'estados_solicitud' => $estados_solicitud, 'message' => $message]);
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
        $doc_registro = $this->getDocumentsTypes();
        $documents = AdopcionDocument::select('id', 'name', 'type', 'mime')->where('solicitud_id', $id)->get();
        return view('solicitud.edit', ['solicitud' => $solicitud, 'estados_solicitud' => $estados_solicitud, 'doc_registro' => $doc_registro, 'documents' => $documents]);
    }

    public function destroy(SolicitudAdopcion $solicitudAdopcion)
    {
        //
    }
}
