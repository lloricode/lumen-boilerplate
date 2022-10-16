<?php

declare(strict_types=1);

namespace Database\Seeders\Auth;

use Database\Seeders\Traits\SeederHelper;
use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    use SeederHelper;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roleModel = app(config('permission.models.role'));
        $permissionModel = app(config('permission.models.permission'));

        $viewBackend = $permissionModel::create(
            [
                'name' => config('setting.permission.permission_names.view_backend'),
            ]
        );

        $manageAuthorization = $permissionModel::create(
            [
                'name' => config('setting.permission.permission_names.manage_authorization'),
            ]
        );

        foreach (config('setting.permission.role_names') as $roleName) {
            $roleModel::create(
                [
                    'name' => $roleName,
                ]
            )->givePermissionTo(
                [
                    $viewBackend,
                    $manageAuthorization,
                ]
            );
        }

        $this->seederPermission($roleModel::PERMISSIONS);
        $this->seederPermission($permissionModel::PERMISSIONS);
    }
}
