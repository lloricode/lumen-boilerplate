<?php

declare(strict_types=1);

namespace Domain\Auth\Actions;

use App\Models\Auth\Permission\Permission;

class FindPermissionByRouteKeyAction
{
    public function execute(string $routeKey): Permission
    {
        $permission = config('permission.models.permission');

        return $permission::where(
            app($permission)->getRouteKeyName(),
            $routeKey
        )->first();
    }
}
