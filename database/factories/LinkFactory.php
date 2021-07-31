<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Link;
use App\User;
use Faker\Generator as Faker;

$factory->define(Link::class, function (Faker $faker) {
    return [
        'user_id' => factory(User::class),
        'original' => $faker->url,
    ];
});
