<?php

use Faker\Generator as Faker;
use Illuminate\Support\Carbon;

$factory->define(App\Customer::class, function (Faker $faker) {
    $faker->addProvider(new \Faker\Provider\ms_MY\PhoneNumber($faker));
    $faker->addProvider(new \Faker\Provider\ms_MY\Person($faker));

    $sex = $faker->randomElement(['male', 'female']);
    $source = $faker->randomElement(['friend', 'google', 'facebook', 'advertisement']);

    $branch = \App\Branch::orderByRaw('RAND()')->first();
    $user = \App\User::where('branch_id', $branch->id)->orderByRaw('RAND()')->first();

    return [
        'full_name' => $faker->name,
        'phone' => $faker->mobileNumber(false, false),
        'ic_number' => $faker->myKadNumber($sex, false),
        'sex' => $sex,
        'branch_id' => $branch->id,
        'user_id' => $user->id,
        'source' => $source,
        'created_at' => Carbon::now(),
    ];
});
