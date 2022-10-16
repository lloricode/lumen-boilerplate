<?php

declare(strict_types=1);

namespace Domain\User\Actions;

use App\Models\Auth\User\User;

class FindUserByRouteKeyAction
{
    public function execute(string $routeKey, bool $throw404 = false): User
    {
        $query =  User::where((new User())->getRouteKeyName(), $routeKey);

        if ($throw404) {
            return $query->firstOrFail();
        }

        return $query->first();
    }
}
