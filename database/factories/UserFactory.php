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
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Models\Schedule::class, function (Faker $faker) {
    return [
        'date' => $faker->date($format = 'Y-m-d', $min = 'now'),
        'event' => $faker->word,
    ];
});

$factory->define(App\Models\Music::class, function (Faker $faker) {
    return [
        'name' => $faker->sentence($nbWords = 6),
        'author' => $faker->name,
    ];
});

$factory->define(App\Models\ScheduleMusic::class, function (Faker $faker) {
    return [
        'schedule_id' => rand(0,10),
        'music_id' => rand(0,10),
    ];
});

$factory->define(App\Models\ScheduleTeam::class, function (Faker $faker) {
    return [
        'schedule_id' => rand(0,10),
        'team_id' => 1,
    ];
});