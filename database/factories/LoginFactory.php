<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use App\Login;
use Illuminate\Support\Str;
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

$factory->define(Login::class, function (Faker $faker) {
    return [
        'username' => $faker->userName,
        'password' => 'password', // password
        'remember_token' => Str::random(10),
        'is_active' => true,
        'user_id' => factory(User::class)->create()->id,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now()
    ];
});
