<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

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
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => '$2y$10$oY.TqBqd1nagQSh701NooeMfsviyRM5w.oOphzCMSCUarLqpNNOFO', // password
        'isPasswordKeptHash' => 1,
        'key' => 'eb3c65fd80fae3d4455529117e9c8c758e9ea73042041c0932b4b0b5f5e4909e6daa51ee82c32136c0bedeb068f170901a62124adbcfa47710faaf19a3a0d448'
    ];
});
