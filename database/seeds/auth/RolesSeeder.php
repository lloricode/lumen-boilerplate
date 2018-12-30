<?php

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

        $viewBackend = $permissionModel::create([
            'name' => 'view backend',
        ]);
        foreach (config('setting.role_names') as $roleName) {
            $roleModel::create([
                'name' => $roleName,
            ])->givePermissionTo($viewBackend);
        }

        $this->seederPermission($roleModel::PERMISSIONS);
        $this->seederPermission($permissionModel::PERMISSIONS);
    }
}
