<?php

declare(strict_types=1);

namespace Database\Seeders;

use Database\Seeders\Auth\AuthSeeder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(AuthSeeder::class);

        shell_exec('php artisan passport:install --force');

        DB::table('oauth_clients')
            ->where('id', 2)
            ->update(['secret' => password_hash('BZnwQmjc0LEi40jVKoW2ICX2LC1K4mG0NKfWBl8Z', PASSWORD_BCRYPT)]);

        app('cache')->flush();
    }
}
