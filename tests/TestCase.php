<?php

declare(strict_types=1);

namespace Test;

use App\Models\Auth\User\User;
use Database\Factories\Auth\User\UserFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Testing\TestCase as BaseTestCase;
use Spatie\Permission\PermissionRegistrar;

abstract class TestCase extends BaseTestCase
{
    use UsesDatabase;

    protected static function userData(): array
    {
        return [
            'first_name' => 'Lloric',
            'last_name' => 'Garcia',
            'email' => 'lloricode@gmail.com',
            'password' => app('hash')->make('secret'),
        ];
    }

    protected static function forId(Model $model): string
    {
        return (string) $model->{$model->getRouteKeyName()};
    }

    protected function setUp(): void
    {
        $this->prepareDatabase();
        parent::setUp();
        $this->setUpDatabase(
            function () {
                $this->artisan('db:seed');
                $this->artisan('passport:install');
            }
        );
        app('cache')->flush();
        $this->app->make(PermissionRegistrar::class)->registerPermissions();
        $this->beginDatabaseTransaction();
        $this->refreshDatabase();
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
            $user = UserFactory::new()->create();
        } else {
            $user = User::role(config("setting.permission.role_names.$roleName"))->first();
        }

        $this->actingAs($user);

        return $user;
    }
}
