<?php

trait SeederHelper
{
    public function seederPermission(array $permissionNames, bool $isAddToAdminRole = true, array $except = [])
    {
        $roleModel = app(config('permission.models.role'));
        $permissionModel = app(config('permission.models.permission'));

        foreach ($permissionNames as $permissionName) {
            $permission = $permissionModel::create([
                'name' => $permissionName,
            ]);
            $roleModel::findByName(config('access.role_names.system'))->givePermissionTo($permission);
            if ($isAddToAdminRole) {
                if (!in_array($permissionName, $except)) {
                    $roleModel::findByName(config('access.role_names.admin'))->givePermissionTo($permission);
                }
            }
        }
    }
}