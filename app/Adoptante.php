<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Adoptante extends Model
{
    const ADOPTANTE_HABILITADO = '1';
    const ADOPTANTE_NO_HABILITADO = '0';
    const ADOPTANTE_ESTADO_CIVIL = ['Casado', 'Soltero', 'Viudo'];

    protected $table = 'adoptantes';
    protected $fillable = [
        'direccion',
        'ocupacion',
        'estado_civil',
        'habilitado',
        'user_id'
    ];

    function user()
    {
        return $this->belongsTo('App\User');
    }

    public function esHabilitado()
    {
        return $this->habilitado == Adoptante::ADOPTANTE_HABILITADO;
    }
}
