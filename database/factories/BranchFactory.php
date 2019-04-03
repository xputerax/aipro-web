<?php

use Faker\Generator as Faker;

$factory->define(\App\Branch::class, function (Faker $faker) {

    $faker->addProvider(new \Faker\Provider\ms_MY\Address($faker));
    $faker->addProvider(new \Faker\Provider\ms_MY\PhoneNumber($faker));

    $townShip = $faker->townShip;

    return [
        'name' => $townShip,
        'address' => implode(", ", [ $townShip, $faker->townState ]),
        'phone' => $faker->fixedLineNumber(true, true),
        'email' => $faker->companyEmail
    ];
});
