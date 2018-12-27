<?php

use App\Models\Auth\User\User;
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
        $system = factory(User::class)->create([
            'first_name' => 'System',
            'last_name' => 'Root',
            'email' => 'system@system.com',
            'password' => app('hash')->make('secret'),
        ]);

        $admin = factory(User::class)->create([
            'email' => 'admin@admin.com',
            'password' => app('hash')->make('secret'),
        ]);

        $user = factory(User::class)->create([
            'email' => 'user@user.com',
            'password' => app('hash')->make('secret'),
        ]);

        $system->assignRole(config('access.role_names.system'));
        $admin->assignRole(config('access.role_names.admin'));

        factory(User::class, 50)->create();

        $this->seederPermission(User::PERMISSIONS);
    }
}
