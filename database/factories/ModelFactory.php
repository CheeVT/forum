<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Reply;
use App\Thread;
use App\Board;
use Faker\Generator as Faker;

$factory->define(Board::class, function (Faker $faker) {
    $name = $faker->word;
    return [
        'name' => $name,
        'slug' => $name,
        'description' => $faker->sentence
    ];
});

$factory->define('App\Thread', function (Faker $faker) {
    return [
        'title' => $faker->sentence,
        'body' => $faker->paragraph,
        'user_id' => function() {
            return factory('App\User')->create()->id;
        },
        'board_id' => function() {
            return factory('App\Board')->create()->id;
        }
    ];
});

$factory->define(Reply::class, function (Faker $faker) {
    return [
        'body' => $faker->paragraph,
        'thread_id' => function() {
            return factory('App\Thread')->create()->id;
        },
        'user_id' => function() {
            return factory('App\User')->create()->id;
        }
    ];
});
