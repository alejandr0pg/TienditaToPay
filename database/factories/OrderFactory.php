<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Order;
use Faker\Generator as Faker;

$factory->define(Order::class, function (Faker $faker) {
    return [
        'customer_name' => $faker->name,
        'customer_email' => $faker->unique()->safeEmail,
        'customer_mobile' => $faker->e164PhoneNumber
    ];
});
