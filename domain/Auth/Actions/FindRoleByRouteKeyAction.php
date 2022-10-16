<?php

declare(strict_types=1);

namespace Domain\Auth\Actions;

use App\Models\Auth\Role\Role;

class FindRoleByRouteKeyAction
{
    public function execute(string $routeKey): Role
    {
        $role = config('permission.models.role');

        return $role::where(
            app($role)->getRouteKeyName(),
            $routeKey
        )->first();
    }
}
