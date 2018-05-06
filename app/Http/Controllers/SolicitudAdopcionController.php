<?php

namespace App\Http\Controllers;

use App\User;
use App\SolicitudAdopcion;
use App\AdopcionDocument;
use App\ValoracionDoctor;
use App\ValoracionPsicologo;
use App\ValoracionTrabajoSocial;
use App\Adoptante;
use App\Infante;
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
            "requisitos" => array(
                1 => "Carta Solicitud",
                2 => "Certificado de Antecedentes",
                3 => "Informe Antecedentes",
                4 => "Verificacion Domiciliaria",
                5 => "Certificado Estado Civil"
            ),
            "valoraciones" => array(
                101 => "Informe Social",
                102 => "Informe Psicologico",
                103 => "Certificado Medico"
            ),
            "otros" => array(
                201 => "Certificado de Idoneidad",
                202 => "Taller de Preparacion",
                203 => "Informe Psicosocial"
            )
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
            0 => "Requisitos",
            1 => "Verificacion de Requisitos",
            2 => "Valoracion",
            3 => "Revision de Documentos",
            4 => "Area Juridica",
            5 => "En Representacion",
            6 => "Asignacion",
            7 => "Acercamiento",
            8 => "Acercamiento Finalizado",
            100 => "Terminado",
            101 => "Requisitos Rechazado",
            102 => "Documentos Rechazado"
        );
    }

    protected function getSolicitudes()
    {
        if (Auth::user()->rol == "Secretaria"){
            return SolicitudAdopcion::with(['adoptante', 'adoptante.user'])->where('estado', 0)->get();
        }elseif (Auth::user()->rol == "Coordinador"){
            return SolicitudAdopcion::with(['adoptante', 'adoptante.user'])->whereIn('estado', array(0, 1, 2, 3, 4, 5))->get();
        }elseif (Auth::user()->rol == "Trabajador Social"){
            return SolicitudAdopcion::with(['adoptante', 'adoptante.user'])->whereIn('estado', array(2, 3, 6, 7))->get();
        }elseif (Auth::user()->rol == "Psicologo"){
            return SolicitudAdopcion::with(['adoptante', 'adoptante.user'])->whereIn('estado', array(2))->get();
        }elseif (Auth::user()->rol == "Doctor"){
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

    protected function saveDocument($doc_file, $id)
    {
        if(Input::hasfile('doc_file')){
            $file = Input::file('doc_file');
            AdopcionDocument::create([
                'type' => $doc_file,
                'name' => $file->getClientOriginalName(),
                'size' => $file->getClientSize(),
                'mime' => $file->getClientMimeType(),
                'file' => base64_encode(file_get_contents($file->getRealPath())),
                'solicitud_id' => $id,
            ]);
        }
    }

    protected function ValoracionisDone($id)
    {
        $solicitud = SolicitudAdopcion::find($id);
        if(is_null($solicitud['valoracion_trabajador_social_id']) or $solicitud['valoracion_trabajador_social']['estado'] == 0){return false;}
        if(is_null($solicitud['valoracion_psicologo_id']) or $solicitud['valoracion_psicologo']['estado'] == 0){return false;}
        if(is_null($solicitud['valoracion_doctor_id']) or $solicitud['valoracion_doctor']['estado'] == 0){return false;}
        return true;
    }

    protected function EdgesDoneArray($id)
    {
        $edge_done = array(
            'requisitos' => false,
            'verificado' => false,
            'val_social' => false,
            'val_psicologica' => false,
            'val_medica' => false,
            'certificado' => false,
            'demanda' => false,
            'area_juridica' => false,
            'asignacion' => false,
            'acercamiento' => false,
            'finalizado' => false
        );
        $solicitud = SolicitudAdopcion::find($id);
        $DocumentsTypesStored = $this->getDocumentsTypesStored($id);
        if($solicitud['estado'] >= 1){$edge_done['requisitos'] = true;}else{return $edge_done;}
        if($solicitud['demanda_adopcion']){$edge_done['demanda'] = true;}
        if($solicitud['estado'] >= 2){$edge_done['verificado'] = true;}else{return $edge_done;}
        if($solicitud['valoracion_trabajador_social']['estado'] == 1){$edge_done['val_social'] = true;}
        if($solicitud['valoracion_psicologo']['estado'] == 1){$edge_done['val_psicologica'] = true;}
        if($solicitud['valoracion_doctor']['estado'] == 1){$edge_done['val_medica'] = true;}
        if($solicitud['estado'] < 3){return $edge_done;}
        if(in_array(202, $DocumentsTypesStored)){$edge_done['certificado'] = true;}
        if($solicitud['estado'] >= 4){$edge_done['area_juridica'] = true;}else{return $edge_done;}
        if($solicitud['estado'] >= 6){$edge_done['asignacion'] = true;}else{return $edge_done;}
        if($solicitud['estado'] >= 7){$edge_done['acercamiento'] = true;}else{return $edge_done;}
        if($solicitud['estado'] >= 8){$edge_done['finalizado'] = true;}else{return $edge_done;}
        return $edge_done;
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
        return view('solicitud.create', ['DocumentsTypes' => $DocumentsTypes['requisitos']]);
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
            $solicitud = SolicitudAdopcion::create([
                'infante_genero' => $request['infante_genero'],
                'infante_edad_desde' => $request['infante_edad_desde'],
                'infante_edad_hasta' => $request['infante_edad_hasta'],
                'adoptante_id' => $adoptante_user['adoptante']['id'],
                'estado' => 0,
                'observacion_registro' => $request['observacion_registro'],
            ]);
            $file = Input::file('doc_file');
            AdopcionDocument::create([
                'type' => $request['doc_type'],
                'name' => $file->getClientOriginalName(),
                'size' => $file->getClientSize(),
                'mime' => $file->getClientMimeType(),
                'file' => base64_encode(file_get_contents($file->getRealPath())),
                'solicitud_id' => $solicitud['id'],
            ]);
        }
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
        $edges_done = $this->EdgesDoneArray($id);
        $solicitud = SolicitudAdopcion::with(['adoptante', 'adoptante.user'])->find($id);
        $DocumentsTypes = $this->getDocumentsTypes();
        $DocumentsTypesStored = $this->getDocumentsTypesStored($id);
        $estados_solicitud = $this->getEstadosToText();
        $documents = AdopcionDocument::select('id', 'name', 'type', 'mime')->where('solicitud_id', $id)->get();
        if($solicitud['estado'] == 0 and in_array(Auth::user()->rol , array("Secretaria", "Administrador"))) {
            return view('solicitud.edit', [
                'solicitud' => $solicitud,
                'DocumentsTypes' => $DocumentsTypes,
                'DocumentsTypesStored' => $DocumentsTypesStored,
                'documents' => $documents,
                'estados_solicitud' => $estados_solicitud,
                'edges_done' => $edges_done
            ]);
        }elseif ($solicitud['estado'] == 1 and in_array(Auth::user()->rol , array("Coordinador", "Administrador"))) {
            $equipo['trabajador_socials'] = User::where('rol', 'Trabajador Social')->get();
            $equipo['psicologos'] = User::where('rol', 'Psicologo')->get();
            $equipo['doctors'] = User::where('rol', 'Doctor')->get();
            return view('solicitud.edit', [
                'solicitud' => $solicitud,
                'DocumentsTypes' => $DocumentsTypes,
                'DocumentsTypesStored' => $DocumentsTypesStored,
                'documents' => $documents,
                'estados_solicitud' => $estados_solicitud,
                'equipo' => $equipo,
                'edges_done' => $edges_done
            ]);
        }
        return view('solicitud.edit', [
            'solicitud' => $solicitud,
            'DocumentsTypes' => $DocumentsTypes,
            'DocumentsTypesStored' => $DocumentsTypesStored,
            'documents' => $documents,
            'estados_solicitud' => $estados_solicitud,
            'edges_done' => $edges_done
        ]);
    }

    public function update(Request $request, $id)
    {
        $DocumentsTypes = $this->getDocumentsTypes();
        $estados_solicitud = $this->getEstadosToText();
        $solicitud = SolicitudAdopcion::with(['adoptante', 'adoptante.user'])->find($id);
        if ($solicitud['estado'] == 0 and in_array(Auth::user()->rol, array("Secretaria", "Administrador"))) {

            $DocumentsTypesStored = $this->getDocumentsTypesStored($id);
            if (count($DocumentsTypes['requisitos']) == count($DocumentsTypesStored)) {
                $solicitud['estado'] = 1;
            }

            if (Input::hasfile('doc_file')) {
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
        } elseif ($solicitud['estado'] == 1 and in_array(Auth::user()->rol, array("Coordinador", "Administrador"))) {
            if (isset($request['verificacion_requisitos'])) {
                $verificacion_requisitos = $request['verificacion_requisitos'] == 'true' ? True : False;
                if ($verificacion_requisitos) {
                    $solicitud['estado'] = 2;
                    $message['success'] = True;
                    $message['success_message'] = 'Solicitud de Adopcion Confirmada Exitosamente';
                    SolicitudAdopcion::where('id', $id)
                        ->update([
                            'estado' => $solicitud['estado'],
                            'observacion_requisitos' => $request['observacion_requisitos'],
                            'trabajador_social_id' => $request['trabajador_social_id'],
                            'psicologo_id' => $request['psicologo_id'],
                            'doctor_id' => $request['doctor_id']
                        ]);
                } else {
                    $this->validatorVerificacionRequisitos($request->all())->validate();
                    $solicitud['estado'] = 101;
                    $message['error'] = True;
                    $message['error_message'] = 'La Solicitud de Adopcion ha sido Rechazada';
                    SolicitudAdopcion::where('id', $id)
                        ->update([
                            'estado' => $solicitud['estado'],
                            'observacion_requisitos' => $request['observacion_requisitos']
                        ]);
                }
            }
            $solicitudes = $this->getSolicitudes();
            return view('solicitud.index', ['solicitudes' => $solicitudes, 'estados_solicitud' => $estados_solicitud, 'message' => $message]);
        } elseif ($solicitud['estado'] == 2 and in_array(Auth::user()->rol, array("Trabajador Social", "Psicologo", "Doctor"))) {
            if (isset($request['fecha_valoracion'])) {
                if (Auth::user()->rol == "Trabajador Social") {
                    $Valoracion = ValoracionTrabajoSocial::create([
                        'fecha_valoracion' => $request['fecha_valoracion'],
                        'estado' => 0
                    ]);
                    SolicitudAdopcion::where('id', $id)
                        ->update([
                            'valoracion_trabajador_social_id' => $Valoracion['id'],
                        ]);
                } elseif (Auth::user()->rol == "Psicologo") {
                    $Valoracion = ValoracionPsicologo::create([
                        'fecha_valoracion' => $request['fecha_valoracion'],
                        'estado' => 0
                    ]);
                    SolicitudAdopcion::where('id', $id)
                        ->update([
                            'valoracion_psicologo_id' => $Valoracion['id'],
                        ]);
                } elseif (Auth::user()->rol == "Doctor") {
                    $Valoracion = ValoracionDoctor::create([
                        'fecha_valoracion' => $request['fecha_valoracion'],
                        'estado' => 0
                    ]);
                    SolicitudAdopcion::where('id', $id)
                        ->update([
                            'valoracion_doctor_id' => $Valoracion['id'],
                        ]);
                }
                $message['success'] = True;
                $message['success_message'] = 'Fecha programada para la valoracion';
                $solicitudes = $this->getSolicitudes();
                return view('solicitud.index', [
                    'solicitudes' => $solicitudes,
                    'estados_solicitud' => $estados_solicitud,
                    'message' => $message
                ]);
            } else {
                if (Auth::user()->rol == "Trabajador Social") {
                    Validator::make($request->all(), [
                        'observacion_trabajador_social' => 'required',
                        'doc_file' => 'required'
                    ])->validate();
                    $this->saveDocument($request['doc_type'], $id);
                    ValoracionTrabajoSocial::where('id', $solicitud['valoracion_trabajador_social_id'])
                        ->update([
                            'condiciones_vivienda' => $request['condiciones_vivienda'] == 'on' ? True : False,
                            'estructura_familiar' => $request['estructura_familiar'] == 'on' ? True : False,
                            'situacion_actual' => $request['situacion_actual'] == 'on' ? True : False,
                            'observacion_trabajador_social' => $request['observacion_trabajador_social'],
                            'estado' => 1
                        ]);
                } elseif (Auth::user()->rol == "Psicologo") {
                    Validator::make($request->all(), [
                        'observacion_psicologo' => 'required',
                        'doc_file' => 'required'
                    ])->validate();
                    $this->saveDocument($request['doc_type'], $id);
                    ValoracionPsicologo::where('id', $solicitud['valoracion_psicologo_id'])
                        ->update([
                            'evaluacion_psicologica' => $request['evaluacion_psicologica'] == 'on' ? True : False,
                            'dinamica_familiar' => $request['dinamica_familiar'] == 'on' ? True : False,
                            'motivacion_adopcion' => $request['motivacion_adopcion'] == 'on' ? True : False,
                            'observacion_psicologo' => $request['observacion_psicologo'],
                            'estado' => 1
                        ]);
                } elseif (Auth::user()->rol == "Doctor") {
                    Validator::make($request->all(), [
                        'observacion_doctor' => 'required',
                        'doc_file' => 'required'
                    ])->validate();
                    $this->saveDocument($request['doc_type'], $id);
                    ValoracionDoctor::where('id', $solicitud['valoracion_doctor_id'])
                        ->update([
                            'condicion_medica' => $request['condicion_medica'] == 'on' ? True : False,
                            'observacion_doctor' => $request['observacion_doctor'],
                            'estado' => 1
                        ]);
                }
                if ($this->ValoracionisDone($id)) {
                    SolicitudAdopcion::where('id', $id)->update(['estado' => 3]);
                }
            }
        } elseif ($solicitud['estado'] == 3 and in_array(Auth::user()->rol, array("Coordinador", "Trabajador Social"))) {
            if (Auth::user()->rol == "Trabajador Social") {
                Validator::make($request->all(), [
                    'doc_file' => 'required',
                ])->validate();
                $this->saveDocument($request['doc_type'], $id);
            } elseif (Auth::user()->rol == "Coordinador") {
                $DocumentsStored = $this->getDocumentsTypesStored($id);
                if (in_array(202, $DocumentsStored)) {
                    if (!in_array(201, $DocumentsStored)) {
                        Validator::make($request->all(), [
                            'doc_file' => 'required',
                        ])->validate();
                        $this->saveDocument($request['doc_type'], $id);
                    }
                    Validator::make($request->all(), [
                        'observacion_documentos' => 'required'
                    ])->validate();
                    SolicitudAdopcion::where('id', $id)
                        ->update([
                            'estado' => 4,
                            'observacion_documentos' => $request['observacion_documentos']
                        ]);
                }
            }
        } elseif ($solicitud['estado'] == 4 and in_array(Auth::user()->rol, array("Abogado"))) {
            Validator::make($request->all(), [
                'observacion_representacion' => 'required'
            ])->validate();
            SolicitudAdopcion::where('id', $id)
                ->update([
                    'estado' => 5,
                    'observacion_representacion' => $request['observacion_representacion']
                ]);
        }elseif($solicitud['estado'] == 5 and in_array(Auth::user()->rol , array("Abogado"))){
            SolicitudAdopcion::where('id', $id)
                ->update([
                    'estado' => 6,
                ]);
        }elseif($solicitud['estado'] == 6 and in_array(Auth::user()->rol , array("Trabajador Social"))){
            Validator::make($request->all(), [
                'infante' => 'required',
            ])->validate();
            Validator::make($request->all(), [
                'infante_id' => 'required|exists:infantes,id'
            ], [
                'required' => 'Seleccione un infante.',
                'exists' => 'Seleccione un infante.'
            ])->validate();
            SolicitudAdopcion::where('id', $id)
                ->update([
                    'estado' => 7,
                    'infante_id' => $request['infante_id'],
                ]);
        }elseif($solicitud['estado'] == 7 and in_array(Auth::user()->rol , array("Trabajador Social"))){
            Validator::make($request->all(), [
                'doc_file' => 'required',
                'observacion_informe_psiosocial' => 'required'
            ])->validate();
            $this->saveDocument($request['doc_type'], $id);
            if($request['informe_psicosocial'] == 'on'){
                Infante::where('id', $solicitud['infante_id'])
                    ->update([
                        'adoptado' => True,
                    ]);
            }
            SolicitudAdopcion::where('id', $id)
                ->update([
                    'estado' => 8,
                    'informe_psicosocial' => $request['informe_psicosocial'] == 'on' ? True : False,
                    'observacion_informe_psiosocial' => $request['observacion_informe_psiosocial']
                ]);
        }elseif($solicitud['estado'] == 8 and in_array(Auth::user()->rol , array("Abogado"))){
            SolicitudAdopcion::where('id', $id)
                ->update([
                    'estado' => 100
                ]);
        }elseif(in_array(Auth::user()->rol , array("Abogado"))) {
            SolicitudAdopcion::where('id', $id)
                ->update([
                    'observacion_demanda' => $request['observacion_demanda'],
                    'demanda_adopcion' => true,
                ]);
        }
        $solicitud = SolicitudAdopcion::with(['adoptante', 'adoptante.user'])->find($id);
        $documents = AdopcionDocument::select('id', 'name', 'type', 'mime')->where('solicitud_id', $id)->get();
        $DocumentsTypesStored = $this->getDocumentsTypesStored($id);
        $edges_done = $this->EdgesDoneArray($id);
        return view('solicitud.edit', [
            'solicitud' => $solicitud,
            'DocumentsTypes' => $DocumentsTypes,
            'DocumentsTypesStored' => $DocumentsTypesStored,
            'documents' => $documents,
            'estados_solicitud' => $estados_solicitud,
            'edges_done' => $edges_done
        ]);
    }

    public function destroy(SolicitudAdopcion $solicitudAdopcion)
    {
        //
    }
}
