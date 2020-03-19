<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Reply;
use App\Thread;
use App\Board;
use Ramsey\Uuid\Uuid;
use Illuminate\Notifications\DatabaseNotification;
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

$factory->define(DatabaseNotification::class, function($faker) {
    return [
        'id' => Uuid::uuid4()->toString(),
        'type' => 'App\Notifications\ThreadIsUpdated',
        'notifiable_id' => auth()->id() ?: factory('App\User')->create()->id(),
        'notifiable_type' => 'App\User',
        'data' => ['foo' => 'bar']
    ];
});
