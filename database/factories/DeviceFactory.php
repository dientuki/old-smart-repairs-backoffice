<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Brand;
use App\Device;
use App\DeviceType;
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

$factory->define(Device::class, function (Faker $faker) {
    return [
        'tradename' => $faker->name,
        'technical_name' => $faker->company,
        'url' => $faker->url,
        'device_type_id' => factory(DeviceType::class)->create()->id,
        'brand_id' => factory(Brand::class)->create()->id
    ];
});
