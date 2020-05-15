<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Client;
use App\Message;
use App\ScheduleMessage;
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

$factory->define(Client::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'timezone' => $faker->timezone,
    ];
});

$factory->define(Message::class, function (Faker $faker) {
    return [
        'text' => $faker->text,
    ];
});

$factory->define(ScheduleMessage::class, function (Faker $faker) {
    return [
        'time' => $faker->time('H:i')
    ];
});
