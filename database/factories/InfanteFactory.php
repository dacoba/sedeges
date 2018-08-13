<?php

use App\User;
use App\Infante;
use Faker\Generator as Faker;

$factory->define(Infante::class, function (Faker $faker) {
    $nombre = $faker->firstName($gender = null|'male'|'female') . " " .  $faker->lastName;
    $fecha_nacimiento_dt = $faker->dateTimeBetween($startDate = '-18 years', $endDate = 'now', $timezone = null);
    $fecha_ingreso_dt = $faker->dateTimeBetween($startDate = $fecha_nacimiento_dt, $endDate = 'now', $timezone = null);
    return [
        'ci' => $faker->unique()->numberBetween($min = 1000000, $max = 9999999),
        'ci_extencion' => $faker->randomElement(User::CI_EXTENSIONS),
        'nombre' => strtoupper($nombre),
        'fecha_nacimiento' => date_format($fecha_nacimiento_dt, 'Y-m-d'),
        'genero' => $faker->randomElement(User::GENERO),
        'fecha_ingreso' => date_format($fecha_ingreso_dt, 'Y-m-d'),
        'descripcion' => $faker->paragraph,
        'habilitado' => $faker->randomElement([0 , 1]),
        'adoptado' => 0,
    ];
});
