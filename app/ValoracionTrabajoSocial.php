<?php

namespace App;

use Jenssegers\Date\Date;
use Illuminate\Database\Eloquent\Model;

class ValoracionTrabajoSocial extends Model
{
    protected $table = 'valoracion_trabajo_socials';
    protected $fillable = [
        'fecha_valoracion', 'condiciones_vivienda', 'estructura_familiar', 'situacion_actual', 'estado'
    ];
    public function getFechaValoracionAttribute($date)
    {
        return new Date($date);
    }
}
