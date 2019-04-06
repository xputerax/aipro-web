<?php

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

$factory->define(App\User::class, function (Faker $faker) {
    $faker->addProvider(new \Faker\Provider\ms_MY\Person($faker));

    return [
        'email' => $faker->safeEmail,
        'username' => $faker->userName,
        'full_name' => $faker->name,
        'password' => '123456',
        'group_id' => 3,
        'branch_id' => 1,
    ];
});
