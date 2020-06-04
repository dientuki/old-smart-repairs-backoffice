<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Device;
use App\Part;
use App\Part2Device;
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

$factory->define(Part2Device::class, function (Faker $faker) {
    return [
        'device_id' => factory(Device::class)->create()->id,
        'part_id' => factory(Part::class)->create()->id
    ];
});
