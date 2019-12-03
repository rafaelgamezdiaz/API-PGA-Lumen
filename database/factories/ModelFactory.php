<?php

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

use App\Models\Client;
$factory->define(Client::class, function (Faker\Generator $faker) {
    return [
        'dni' => $faker->randomNumber(8),
        'commerce_name' => $faker->company,
        'name' => $faker->name,
        'last_name' => $faker->lastName,
        'description' => "a description",
        'phone' => $faker->phoneNumber,
        'address' => $faker->address,
        'email' => $faker->email,
        'image'=>$faker->imageUrl(),
        'type' => $faker->randomElement([1,2,3]),
        'status'=> $faker->randomElement([1,2]),
        'account'=> $faker->randomElement([1,2,3,4,5,6,7,8])
    ];
});
