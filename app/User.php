<?php

namespace App;

use Jenssegers\Date\Date;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    const USUARIO_HABILITADO = '1';
    const USUARIO_NO_HABILITADO = '0';
    const USUARIO_ADMINISTRADOR = 'true';
    const USUARIO_REGULAR = 'false';
    const USUARIO_GENERO = ['Masculino', 'Femenino'];
    const USUARIO_ROLES = [
        'SE' => 'Secretaria',
        'CO' => 'Cordinador',
        'TS' => 'Trabajador Social',
        'PS' => 'Psicologo',
        'ME' => 'Medico',
        'AB' => 'Abogado',
        'AD' => 'Adoptante',
    ];
    const USUARIO_CI_EXT = ['LP', 'CB', 'SCZ', 'TR', 'OR', 'PT', 'SC', 'BI', 'PA'];

    protected $fillable = [
        'ci',
        'ci_extencion',
        'email',
        'nombres',
        'apellido_paterno',
        'apellido_materno',
        'genero',
        'fecha_nacimiento',
        'telefono_fijo',
        'telefono_celular',
        'habilitado',
        'admin',
        'rol',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token'
    ];

    function adoptante()
    {
        return $this->hasOne('App\Adoptante');
    }

    public function setNombresAttribute($valor)
    {
        $this->attributes['nombres'] = strtoupper($valor);
    }

    public function setApellidoPaternoAttribute($valor)
    {
        $this->attributes['apellido_paterno'] = strtoupper($valor);
    }

    public function setApellidoMaternoAttribute($valor)
    {
        $this->attributes['apellido_materno'] = strtoupper($valor);
    }

    public function setEmailAttribute($valor)
    {
        $this->attributes['email'] = strtolower($valor);
    }

    public function getFechaNacimientoAttribute($date)
    {
        return new Date($date);
    }

    public function esHabilitado()
    {
        return $this->habilitado == User::USUARIO_HABILITADO;
    }

    public function esAdmin()
    {
        return $this->admin == User::USUARIO_ADMINISTRADOR;
    }
}
