<?php

use App\Centro;
use Faker\Generator as Faker;

$factory->define(Centro::class, function (Faker $faker) {
    return [
        'nombre_centro' => $faker->company,
        'capacidad' => $faker->numberBetween($min = 10, $max = 40),
        'direccion' => $faker->address,
        'nombre_director' => $faker->name,
        'telefono' => $faker->numberBetween($min = 4000000, $max = 4999999),
        'fecha_fundacion' => $faker->date($format = 'Y-m-d', $max = 'now')
    ];
});
