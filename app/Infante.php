<?php

namespace App;

use Jenssegers\Date\Date;
use Illuminate\Database\Eloquent\Model;

class Infante extends Model
{
    protected $table = 'infantes';
    protected $fillable = [
        'ci',
        'ci_extencion',
        'nombre',
        'fecha_nacimiento',
        'genero',
        'fecha_ingreso',
        'descripcion',
        'habilitado',
        'adoptado',
        'centro_id'
    ];

    function centro()
    {
        return $this->belongsTo('App\Centro');
    }

    public function setNombreAttribute($valor)
    {
        $this->attributes['nombre'] = strtoupper($valor);
    }

    public function getFechaNacimientoAttribute($date)
    {
        return new Date($date);
    }

    public function getFechaIngresoAttribute($date)
    {
        return new Date($date);
    }
}
