<?php

declare(strict_types=1);

namespace Domain\User\Actions;

use App\Models\Auth\User\User;

class CreateUserAction
{
    public function execute(array $attributes): User
    {
        $attributes['password'] = app('hash')->make($attributes['password']);

        return User::create($attributes);
    }
}
