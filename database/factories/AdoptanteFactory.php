<?php

use App\Adoptante;
use Faker\Generator as Faker;

$factory->define(Adoptante::class, function (Faker $faker) {
    return [
        'direccion' => $faker->address,
        'ocupacion' => $faker->jobTitle,
        'estado_civil' => $faker->randomElement(Adoptante::ESTADO_CIVIL),
        'desabilitado' => $faker->randomElement([0 , 1]),
    ];
});
