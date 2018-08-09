<?php

use App\User;
use App\Infante;
use Faker\Generator as Faker;

$factory->define(Infante::class, function (Faker $faker) {
    return [
        'ci' => $faker->numberBetween($min = 1000000, $max = 9999999),
        'ci_extencion' => $faker->randomElement(User::CI_EXTENSIONS),
        'nombre' => $faker->name,
        'fecha_nacimiento' => $faker->date($format = 'Y-m-d', $max = 'now'),
        'genero' => $faker->randomElement(User::GENERO),
        'fecha_ingreso' => $faker->date($format = 'Y-m-d', $max = 'now'),
        'descripcion' => $faker->paragraph,
        'habilitado' => $faker->randomElement([0 , 1]),
        'adoptado' => $faker->randomElement([0 , 1]),
        'centro_id' => $faker->numberBetween($min = 1, $max = 20),
    ];
});
