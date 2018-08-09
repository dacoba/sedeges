<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Centro extends Model
{
    protected $table = 'centros';
    protected $fillable = [
        'nombre_centro', 'capacidad', 'direccion', 'nombre_director', 'telefono', 'fecha_fundacion',
    ];

    function infantes(){
        return $this->hasMany('App\Infante');
    }
}
