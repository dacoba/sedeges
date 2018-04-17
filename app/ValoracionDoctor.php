<?php

namespace App;

use Jenssegers\Date\Date;
use Illuminate\Database\Eloquent\Model;

class ValoracionDoctor extends Model
{
    protected $table = 'valoracion_doctors';
    protected $fillable = [
        'fecha_valoracion', 'condicion_medica', 'estado'
    ];
    public function getFechaValoracionAttribute($date)
    {
        return new Date($date);
    }
}
