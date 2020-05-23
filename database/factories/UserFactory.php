<?php
/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Auth\User\User;

$factory->define(
    User::class,
    function (Faker\Generator $faker) {
        return [
            'first_name' => $faker->firstName,
            'last_name' => $faker->lastName,
            'email' => $faker->unique()->email,
            'password' => app('hash')->make('secret'),
        ];
    }
);
