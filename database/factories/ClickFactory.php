<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Click;
use App\Link;
use App\Model;
use Faker\Generator as Faker;

$factory->define(Click::class, function (Faker $faker) {
    return [
        'link_id' => factory(Link::class),
    ];
});
