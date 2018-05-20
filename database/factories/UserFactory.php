<?php

use App\User;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    return [
        'email' => $faker->unique()->safeEmail,
        'nombres' => $faker->firstName,
        'apellido_paterno' => $faker->lastName,
        'apellido_materno' => $faker->lastName,
        'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm',
        'remember_token' => str_random(10),
        'ci' => $faker->numberBetween(7,8),
        'ci_extencion' => $faker->randomElement(User::USUARIO_CI_EXT),
        'genero' => $faker->randomElement(User::USUARIO_GENERO),
        'fecha_nacimiento' => $faker->dateTimeBetween('-55years', '-25years'),
        'telefono_fijo' => $faker->numberBetween($min = 4000000, $max = 4999999),
        'telefono_celular' => $faker->numberBetween($min = 60000000, $max = 79999999),
        'habilitado' => $verificado = $faker->randomElement([User::USUARIO_HABILITADO, User::USUARIO_NO_HABILITADO]),
        'admin' => $faker->randomElement([User::USUARIO_ADMINISTRADOR, User::USUARIO_REGULAR]),
        'rol' => $faker->randomElement(User::USUARIO_ROLES),
    ];
});
