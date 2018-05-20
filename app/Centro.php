<?php

namespace App;

use Jenssegers\Date\Date;
use Illuminate\Database\Eloquent\Model;

class Centro extends Model
{
    protected $table = 'centros';
    protected $fillable = [
        'nombre_centro',
        'direccion',
        'nombre_director',
        'telefono',
        'fecha_fundacion',
    ];

    public function setNombreCentroAttribute($valor)
    {
        $this->attributes['nombre_centro'] = strtoupper($valor);
    }

    public function setNombreDirectorAttribute($valor)
    {
        $this->attributes['nombre_director'] = strtoupper($valor);
    }

    public function getFechaFundacionAttribute($date)
    {
        return new Date($date);
    }
}
