<?php

namespace App;

use Jenssegers\Date\Date;
use Illuminate\Database\Eloquent\Model;

class SolicitudAdopcion extends Model
{
    protected $table = 'solicitud_adopcions';
    protected $fillable = [
        'infante_genero', 'infante_edad_desde', 'infante_edad_hasta', 'infante_id', 'adoptante_id', 'estado',
        'observacion_registro', 'observacion_requisitos'
    ];
    function infante(){
        return $this->belongsTo('App\Infante');
    }
    function adoptante(){
        return $this->belongsTo('App\Adoptante');
    }

    public function getCreatedAtAttribute($date)
    {
        return new Date($date);
    }
}