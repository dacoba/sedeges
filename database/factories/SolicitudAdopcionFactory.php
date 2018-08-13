<?php

use App\SolicitudAdopcion;
use Faker\Generator as Faker;

$factory->define(SolicitudAdopcion::class, function (Faker $faker) {
    return [
        'observacion_registro' => $faker->paragraph,
    ];
});
