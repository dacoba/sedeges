<?php

use App\Centro;
use Faker\Generator as Faker;

$factory->define(Centro::class, function (Faker $faker) {
    return [
        'nombre_centro' => $faker->company,
        'direccion' => $faker->address,
        'nombre_director' => $faker->name,
        'telefono' => $faker->phoneNumber,
        'fecha_fundacion' => $faker->date($format = 'Y-m-d', $max = 'now')
    ];
});
