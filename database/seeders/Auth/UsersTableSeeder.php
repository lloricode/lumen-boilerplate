<?php

declare(strict_types=1);

namespace Database\Seeders\Auth;

use App\Models\Auth\User\User;
use Database\Factories\Auth\User\UserFactory;
use Database\Seeders\Traits\SeederHelper;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    use SeederHelper;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $system = UserFactory::new()->create(
            [
                'first_name' => 'System',
                'last_name' => 'Root',
                'email' => 'system@system.com',
                'password' => app('hash')->make('secret'),
            ]
        );

        $admin = UserFactory::new()->create(
            [
                'email' => 'admin@admin.com',
                'password' => app('hash')->make('secret'),
            ]
        );

        $user = UserFactory::new()->create(
            [
                'email' => 'user@user.com',
                'password' => app('hash')->make('secret'),
            ]
        );

        $system->assignRole(config('setting.permission.role_names.system'));
        $admin->assignRole(config('setting.permission.role_names.admin'));

        UserFactory::new()->count(50)->create();

        $this->seederPermission(User::PERMISSIONS);
    }
}
