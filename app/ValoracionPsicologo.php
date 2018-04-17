<?php

namespace App;

use Jenssegers\Date\Date;
use Illuminate\Database\Eloquent\Model;

class ValoracionPsicologo extends Model
{
    protected $table = 'valoracion_psicologos';
    protected $fillable = [
        'fecha_valoracion', 'evaluacion_psicologica', 'dinamica_familiar', 'motivacion_adopcion', 'estado'
    ];
    public function getFechaValoracionAttribute($date)
    {
        return new Date($date);
    }
}
