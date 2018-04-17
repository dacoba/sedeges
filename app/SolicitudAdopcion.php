<?php

namespace App;

use Jenssegers\Date\Date;
use Illuminate\Database\Eloquent\Model;

class SolicitudAdopcion extends Model
{
    protected $table = 'solicitud_adopcions';
    protected $fillable = [
        'infante_genero', 'infante_edad_desde', 'infante_edad_hasta', 'infante_id', 'adoptante_id', 'estado',
        'trabajador_social_id', 'psicologo_id', 'doctor_id',
        'valoracion_trabajador_social_id', 'valoracion_psicologo_id', 'valoracion_doctor_id',
        'observacion_registro', 'observacion_requisitos'
    ];
    function infante(){
        return $this->belongsTo('App\Infante');
    }
    function adoptante(){
        return $this->belongsTo('App\Adoptante');
    }
    function trabajador_social(){
        return $this->belongsTo('App\User');
    }
    function psicologo(){
        return $this->belongsTo('App\User');
    }
    function doctor(){
        return $this->belongsTo('App\User');
    }
    function valoracion_trabajador_social(){
        return $this->belongsTo('App\ValoracionTrabajoSocial');
    }
    function valoracion_psicologo(){
        return $this->belongsTo('App\ValoracionPsicologo');
    }
    function valoracion_doctor(){
        return $this->belongsTo('App\ValoracionDoctor');
    }

    public function getCreatedAtAttribute($date)
    {
        return new Date($date);
    }
}
