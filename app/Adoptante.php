<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Adoptante extends Model
{
    const ESTADO_CIVIL = [
        'Casado',
        'Soltero',
        'Viudo'
    ];

    protected $table = 'adoptantes';
    protected $fillable = [
        'direccion', 'ocupacion', 'estado_civil', 'desabilitado', 'user_id',
    ];
    function user(){
        return $this->belongsTo('App\User');
    }
    function solicitudes()
    {
        return $this->hasMany('App\SolicitudAdopcion');
    }
}
