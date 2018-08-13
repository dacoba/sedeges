<?php

use App\Centro;
use Faker\Generator as Faker;

$factory->define(Centro::class, function (Faker $faker) {
    $nombre_director = $faker->firstName($gender = null|'male'|'female') . " " .  $faker->lastName;
    return [
        'nombre_centro' => strtoupper($faker->unique()->company),
        'capacidad' => $faker->numberBetween($min = 10, $max = 40),
        'direccion' => $faker->address,
        'nombre_director' => strtoupper($nombre_director),
        'telefono' => $faker->numberBetween($min = 4000000, $max = 4999999),
        'fecha_fundacion' => $faker->date($format = 'Y-m-d', $max = 'now')
    ];
});
