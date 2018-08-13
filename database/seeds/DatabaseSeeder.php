<?php

use App\User;
use App\Centro;
use App\Infante;
use App\Adoptante;
use App\ValoracionDoctor;
use App\SolicitudAdopcion;
use App\AdopcionDocument;
use App\ValoracionPsicologo;
use Illuminate\Database\Seeder;
use App\ValoracionTrabajoSocial;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        factory(Centro::class, 5)->create()->each(
            function ($centro) {
                $cantidad = rand(1, $centro->capacidad);
                factory(Infante::class, $cantidad)->create([
                    'centro_id' => $centro->id,
                ]);
            }
        );
        factory(User::class, 20)->create([
            'rol' => 'Adoptante',
        ])->each(
            function ($user) {
                factory(Adoptante::class, 1)->create([
                    'user_id' => $user->id,
                ])->each(
                    function ($adoptante) {
                        $faker = Faker\Factory::create();
                        $genero = $faker->randomElement(User::GENERO);
                        $edad_hasta = rand(1, 17);
                        $edad_desde = rand(0, $edad_hasta);

                        $edad_desde_dt = '-'.$edad_desde.' years';
                        $edad_hasta_dt = '-'.$edad_hasta.' years';
                        $fecha_nacimiento_dt = $faker->dateTimeBetween($startDate = $edad_hasta_dt, $endDate = $edad_desde_dt, $timezone = null);
                        $fecha_ingreso_dt = $faker->dateTimeBetween($startDate = $fecha_nacimiento_dt, $endDate = 'now', $timezone = null);
                        $nombre = $faker->firstName($gender = null|'male'|'female') . " " .  $faker->lastName;
                        $centro = Centro::get()->random();
                        $infante = Infante::create([
                            'ci' => $faker->unique()->numberBetween($min = 1000000, $max = 9999999),
                            'ci_extencion' => $faker->randomElement(User::CI_EXTENSIONS),
                            'nombre' => strtoupper($nombre),
                            'fecha_nacimiento' => date_format($fecha_nacimiento_dt, 'Y-m-d'),
                            'fecha_ingreso' => date_format($fecha_ingreso_dt, 'Y-m-d'),
                            'genero' => $genero,
                            'descripcion' => $faker->paragraph,
                            'centro_id' => $centro->id,
                            'habilitado' => 1,
                            'adoptado' => 1,
                        ]);

                        $valoracionDoctor = ValoracionDoctor::create([
                            'fecha_valoracion' => $faker->date($format = 'Y-m-d', $max = 'now'),
                            'condicion_medica' => $faker->randomElement([0 , 1]),
                            'observacion_doctor' => $faker->paragraph,
                            'estado' => 1,
                        ]);

                        $valoracionPsicologo = ValoracionPsicologo::create([
                            'fecha_valoracion' => $faker->date($format = 'Y-m-d', $max = 'now'),
                            'evaluacion_psicologica' => $faker->randomElement([0 , 1]),
                            'dinamica_familiar' => $faker->randomElement([0 , 1]),
                            'motivacion_adopcion' => $faker->randomElement([0 , 1]),
                            'observacion_psicologo' => $faker->paragraph,
                            'estado' => 1,
                        ]);

                        $valoracionTrabajoSocial = ValoracionTrabajoSocial::create([
                            'fecha_valoracion' => $faker->date($format = 'Y-m-d', $max = 'now'),
                            'condiciones_vivienda' => $faker->randomElement([0 , 1]),
                            'estructura_familiar' => $faker->randomElement([0 , 1]),
                            'situacion_actual' => $faker->randomElement([0 , 1]),
                            'observacion_trabajador_social' => $faker->paragraph,
                            'estado' => 1,
                        ]);

                        factory(SolicitudAdopcion::class, 1)->create([
                            'infante_genero' => $genero,
                            'infante_edad_desde' => $edad_desde,
                            'infante_edad_hasta' => $edad_hasta,
                            'infante_id' => $infante->id,
                            'adoptante_id' => $adoptante->id,
                            'estado' => 100,
                            'trabajador_social_id' => User::where('rol', 'Trabajador Social')->get()->random()->id,
                            'psicologo_id' => User::where('rol', 'Psicologo')->get()->random()->id,
                            'doctor_id' => User::where('rol', 'Doctor')->get()->random()->id,
                            'valoracion_trabajador_social_id' => $valoracionTrabajoSocial->id,
                            'valoracion_psicologo_id' => $valoracionPsicologo->id,
                            'valoracion_doctor_id' => $valoracionDoctor->id,
                        ])->each(
                            function ($solicitudAdopcion) {
                                foreach (array_keys(AdopcionDocument::DOCUMENTS_TIPES) as $type)
                                {
                                    factory(AdopcionDocument::class, 1)->create([
                                        'type' => $type,
                                        'solicitud_id' => $solicitudAdopcion->id,
                                    ]);
                                }
                            }
                        );
                    }
                );
            }
        );
    }
}
