<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'ci' => '100000000',
            'ci_extencion' => 'LP',
            'nombres' => 'Administrador',
            'apellido_paterno' => 'Administrador',
            'apellido_materno' => 'Administrador',
            'genero' => 'Masculino',
            'fecha_nacimiento' => '1990-01-01',
            'telefono_fijo' => '4000000',
            'telefono_celular' => '70000000',
            'rol' => 'Administrador',
            'email' => 'admin',
            'password' => bcrypt('admin'),
        ]);
        DB::table('users')->insert([
            'ci' => '56197813',
            'ci_extencion' => 'LP',
            'nombres' => 'MELIZA',
            'apellido_paterno' => 'SANGUEZA',
            'apellido_materno' => 'TORRICO',
            'genero' => 'Femenino',
            'fecha_nacimiento' => '1985-07-24',
            'telefono_fijo' => '4456128',
            'telefono_celular' => '72701781',
            'rol' => 'Secretaria',
            'email' => 'meliza_sangueza@gmail.com',
            'password' => bcrypt('secretaria'),
        ]);
        DB::table('users')->insert([
            'ci' => '5511844',
            'ci_extencion' => 'PT',
            'nombres' => 'FRANCO',
            'apellido_paterno' => 'SERRATO',
            'apellido_materno' => 'FLORES',
            'genero' => 'Masculino',
            'fecha_nacimiento' => '1989-01-18',
            'telefono_fijo' => '4455321',
            'telefono_celular' => '72709038',
            'rol' => 'Coordinador',
            'email' => 'franco_serrato@gmail.com',
            'password' => bcrypt('coordinador'),
        ]);
        DB::table('users')->insert([
            'ci' => '84681669',
            'ci_extencion' => 'CB',
            'nombres' => 'CAREN',
            'apellido_paterno' => 'HERRERA',
            'apellido_materno' => 'PEREZ',
            'genero' => 'Femenino',
            'fecha_nacimiento' => '1980-04-14',
            'telefono_fijo' => '4859715',
            'telefono_celular' => '72258761',
            'rol' => 'Trabajador Social',
            'email' => 'caren_herrera@gmail.com',
            'password' => bcrypt('trabajadorsocial'),
        ]);
        DB::table('users')->insert([
            'ci' => '35981758',
            'ci_extencion' => 'OR',
            'nombres' => 'ANDRES',
            'apellido_paterno' => 'CASTRO',
            'apellido_materno' => 'PAZ',
            'genero' => 'Masculino',
            'fecha_nacimiento' => '1990-06-25',
            'telefono_fijo' => '4198177',
            'telefono_celular' => '79781871',
            'rol' => 'Psicologo',
            'email' => 'andres_castro@gmail.com',
            'password' => bcrypt('psicologo'),
        ]);
        DB::table('users')->insert([
            'ci' => '9819687',
            'ci_extencion' => 'CB',
            'nombres' => 'CARLOS',
            'apellido_paterno' => 'CABRERA',
            'apellido_materno' => 'ROCHA',
            'genero' => 'Masculino',
            'fecha_nacimiento' => '1988-09-30',
            'telefono_fijo' => '4858596',
            'telefono_celular' => '70754815',
            'rol' => 'Doctor',
            'email' => 'carlos_cabrera@gmail.com',
            'password' => bcrypt('doctor'),
        ]);
        DB::table('users')->insert([
            'ci' => '42587752',
            'ci_extencion' => 'SCZ',
            'nombres' => 'ALVARO',
            'apellido_paterno' => 'LARUTA',
            'apellido_materno' => 'QUIROZ',
            'genero' => 'Masculino',
            'fecha_nacimiento' => '1988-11-20',
            'telefono_fijo' => '4252505',
            'telefono_celular' => '70766286',
            'rol' => 'Abogado',
            'email' => 'alvaro_laruta@gmail.com',
            'password' => bcrypt('abogado'),
        ]);
    }
}
