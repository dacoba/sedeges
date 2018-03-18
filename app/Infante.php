<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Infante extends Model
{
    protected $table = 'infantes';
    protected $fillable = [
        'ci', 'ci_extencion', 'nombre', 'fecha_nacimiento', 'fecha_ingreso', 'descripcion', 'habilitado', 'adoptado', 'centro_id',
    ];
    function centro(){
        return $this->belongsTo('App\Centro');
    }
}
