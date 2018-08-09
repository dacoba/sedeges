<?php

namespace App;

use Jenssegers\Date\Date;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    const CI_EXTENSIONS = array('LP', 'CB', 'SCZ', 'TR', 'OR', 'PT', 'SC', 'BI', 'PA');
    const GENERO = ['Masculino', 'Femenino'];

    protected $fillable = [
        'ci', 'ci_extencion', 'nombres', 'apellido_paterno', 'apellido_materno', 'genero', 'fecha_nacimiento', 'telefono_fijo', 'telefono_celular', 'desabilitado', 'rol', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    function adoptante()
    {
        return $this->hasOne('App\Adoptante');
    }
    public function getFechaNacimientoAttribute($date)
    {
        return new Date($date);
    }
}
