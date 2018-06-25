<?php
use App\Factura;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->email,
        'email_verified' => 1,
        'email_verification_code' => str_random(10),
        'avatar' => 'test',
        //use bcrypt('password') if you want to assert for a specific password, but it might slow down your tests
        'password' => str_random(10),
    ];
});

$factory->define(App\PasswordReset::class, function (Faker\Generator $faker) {
    return [
        'email'  => $faker->safeEmail,
        'token' => str_random(10),
    ];
});

$factory->define(App\Factura::class, function (Faker\Generator $faker) {

    return [
        'numero'    => random_int(0,10),
        'idEmpresa' => 1,
        'idCliente' => random_int(1,2),
        'Subtotal'  => $sub = random_int(0,10),
        'IVA'       => $iva = ($sub*25)/100 ,
        'total'     => $sub + $iva
    ];
});
