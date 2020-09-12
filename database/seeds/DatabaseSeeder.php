<?php

use Illuminate\Database\Seeder;
use Prettus\Repository\Helpers\CacheKeys;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call('AuthSeeder');

        shell_exec('php artisan passport:install --force');

        DB::table('oauth_clients')
            ->where('id', 2)
            ->update(['secret' => password_hash('BZnwQmjc0LEi40jVKoW2ICX2LC1K4mG0NKfWBl8Z', PASSWORD_BCRYPT)]);

        app('cache')->flush();
        @unlink(CacheKeys::getFileKeys());
    }
}
