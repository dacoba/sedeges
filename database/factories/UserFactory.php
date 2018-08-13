<?php

use App\User;
use Faker\Generator as Faker;

$factory->define(User::class, function (Faker $faker) {
    $fecha_nacimiento_dt = $faker->dateTimeBetween($startDate = '-55 years', $endDate = '-25 years', $timezone = null);
    return [
        'ci' => $faker->unique()->numberBetween($min = 1000000, $max = 9999999),
        'ci_extencion' => $faker->randomElement(User::CI_EXTENSIONS),
        'nombres' => strtoupper($faker->firstName($gender = null|'male'|'female')),
        'apellido_paterno' => strtoupper($faker->lastName),
        'apellido_materno' => strtoupper($faker->lastName),
        'genero' => $faker->randomElement(User::GENERO),
        'fecha_nacimiento' => date_format($fecha_nacimiento_dt, 'Y-m-d'),
        'telefono_fijo' => $faker->numberBetween($min = 4000000, $max = 4999999),
        'telefono_celular' => $faker->numberBetween($min = 60000000, $max = 79999999),
        'desabilitado' => $faker->randomElement([0 , 1]),
        'email' => $faker->unique()->safeEmail,
        'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        'remember_token' => str_random(10),
    ];
});
