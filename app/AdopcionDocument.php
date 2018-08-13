<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdopcionDocument extends Model
{
    const DOCUMENTS_TIPES = [
        1 => "Carta Solicitud",
        2 => "Certificado de Antecedentes",
        3 => "Informe Antecedentes",
        4 => "Verificacion Domiciliaria",
        5 => "Certificado Estado Civil",
        101 => "Informe Social",
        102 => "Informe Psicologico",
        103 => "Certificado Medico",
        201 => "Certificado de Idoneidad",
        202 => "Taller de Preparacion",
        203 => "Informe Psicosocial"
    ];

    protected $table = 'adopcion_documents';
    protected $fillable = [
        'name', 'type', 'mime', 'size', 'file', 'solicitud_id',
    ];
}
