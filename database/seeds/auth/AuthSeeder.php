<?php

use Illuminate\Database\Seeder;

class AuthSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call('RolesSeeder');
        $this->call('UsersTableSeeder');
    }
}
