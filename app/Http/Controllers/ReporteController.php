<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Jenssegers\Date\Date;
use App\SolicitudAdopcion;
use Illuminate\Http\Request;

class ReporteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
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

    public function solicitudReporteIndex()
    {
        $date_from = new Carbon('first day of this month');
        $date_to = new Carbon('last day of this month');
        $estados_solicitud = $this->getEstadosToText();
        return view('reporte.solicitudForm', [
            'date_from' => $date_from->format("Y-m-d"),
            'date_to' => $date_to->format("Y-m-d"),
            'estados_solicitud' => $estados_solicitud
        ]);
    }

    protected function getSolicitues(Request $request)
    {
        return SolicitudAdopcion::where('created_at','>=', $request->date_from)
            ->where('created_at','<=',$request->date_to.' 23:59:59')
            ->orderBy('created_at', 'asc');
    }

    public function solicitudReporte(Request $request)
    {
        $estados_solicitud = $this->getEstadosToText();

        $estados_aux = $this->getSolicitues($request)->get()->pluck('estado')->unique();
        foreach ($estados_aux as $estado)
        {
            $valores[] = $this->getSolicitues($request)->where('estado', $estado)->get()->count();
            $estados[] = $estados_solicitud[$estado];
        }

        $solicitudes = $this->getSolicitues($request)->get();
        $solicitudes_registradas = $this->getSolicitues($request)->get()->count();

        if ($request->has('estado') && $request->estado != '-1') {
            $solicitudes = $this->getSolicitues($request)->where('estado', $request->estado)->get();
            $valores = [$this->getSolicitues($request)->where('estado', $request->estado)->get()->count()];
            $estados = [$estados_solicitud[$request->estado]];
            $estado_definido = True;
        }

        return view('reporte.solicitud', [
            'estados' => $estados,
            'valores' => $valores,
            'solicitudes' => $solicitudes,
            'estado_definido' => $estado_definido,
            'solicitudes_registradas' => $solicitudes_registradas,
            'date_from' => new Date($request->date_from),
            'date_to' => new Date($request->date_to),
            'estados_solicitud' => $estados_solicitud
        ]);
    }
}
