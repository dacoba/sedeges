<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Centro extends Model
{
    protected $table = 'centros';
    protected $fillable = [
        'nombre_centro', 'direccion', 'nombre_director', 'telefono', 'fecha_fundacion',
    ];
}
