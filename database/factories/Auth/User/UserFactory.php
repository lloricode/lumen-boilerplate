<?php

declare(strict_types=1);

namespace Database\Factories\Auth\User;

use Database\Factories\BaseFactory;

class UserFactory extends BaseFactory
{
    public function definition()
    {
        return [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'email' => $this->faker->unique()->email,
            'password' => app('hash')->make('secret'),
        ];
    }
}
