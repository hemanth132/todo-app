<?php

use Faker\Generator as Faker;

$factory->define(\App\User::class, function (Faker $faker) {
    return [
        'email' => $faker->unique()->safeEmail,
        'password' => md5('hemanth')
    ];
});


$factory->define(\App\ToDoList::class, function (Faker $faker) {
    return [
        'title' => $faker->unique()->word
    ];
});

$factory->define(\App\Task::class, function (Faker $faker) {
    return [
        'description' => $faker->unique()->sentence($nbWords = 3)
    ];
});