<?php

use Faker\Generator as Faker;

$factory->define(App\User::class, function (Faker $faker) {
    return [
        'email' => $faker->unique()->safeEmail,
        'password' => '4bb52c85cb51237d8c57d894201a0c2d'
    ];
});


$factory->define(App\ToDoList::class, function (Faker $faker) {
    return [
        'title' => $faker->unique()->word
    ];
});

$factory->define(App\Task::class, function (Faker $faker) {
    return [
        'description' => $faker->unique()->sentence($nbWords = 3)
    ];
});