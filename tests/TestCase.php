<?php

namespace Test;

use App\Models\Auth\User\User;
use Laravel\Lumen\Testing\TestCase as BaseTestCase;
use Laravel\Passport\Passport;
use Spatie\Permission\PermissionRegistrar;

abstract class TestCase extends BaseTestCase
{
    use UsesDatabase;

    public function setUp(): void
    {
        $this->prepareDatabase();
        parent::setUp();
        $this->setUpDatabase(
            function () {
                $this->artisan('db:seed');
                $this->artisan('passport:install');
            }
        );
        app('cache')
            ->store(
                config('permission.cache.store') != 'default'
                    ? config('permission.cache.store')
                    : null
            )
            ->forget(config('permission.cache.key'));
        app('cache')->flush();
        $this->app->make(PermissionRegistrar::class)->registerPermissions();
        $this->beginDatabaseTransaction();
    }

    /**
     * Creates the application.
     *
     * @return \Laravel\Lumen\Application
     */
    public function createApplication()
    {
        return require __DIR__.'/../bootstrap/app.php';
    }

    /**
     * @param  array  $headers
     * @param  bool  $isServer
     *
     * @return array
     */
    protected function addHeaders(array $headers = [], bool $isServer = false)
    {
        $headers += [
            'Accept' => 'application/x.lumen.boilerplate.v1+json',
            'Authorization' => 'Bearer xxxxx',
//            'Accept-Language' =>'en',
        ];

        return $isServer
            ? $this->transformHeadersToServerVars($headers)
            : $headers;
    }

    protected function loggedInAs(string $roleName = 'system'): User
    {
        if ($roleName == 'user') {
            $user = factory(User::class)->create();
        } else {
            $user = User::role(config("setting.permission.role_names.$roleName"))->first();
        }
        Passport::actingAs($user);
//        $this->actingAs($user);

        return $user;
    }

    protected function userData(): array
    {
        return [
            'first_name' => 'Lloric',
            'last_name' => 'Garcia',
            'email' => 'lloricode@gmail.com',
            'password' => app('hash')->make('secret'),
        ];
    }
}
