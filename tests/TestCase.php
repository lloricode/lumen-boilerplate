<?php

namespace Tests;

use App\Models\Auth\User\User;
use Laravel\Lumen\Testing\TestCase as BaseTestCase;
use Laravel\Passport\Passport;

abstract class TestCase extends BaseTestCase
{
    use UsesDatabase;

    public function setUp()
    {
        $this->prepareDatabase();
        parent::setUp();
        $this->setUpDatabase(function () {
            $this->artisan('db:seed');
            $this->artisan('passport:install');
        });
        app('cache')
            ->store(
                config('permission.cache.store') != 'default'
                    ? config('permission.cache.store')
                    : null
            )
            ->forget(config('permission.cache.key'));
        app('cache')->flush();
        $this->app->make(\Spatie\Permission\PermissionRegistrar::class)->registerPermissions();
        $this->beginDatabaseTransaction();
    }

    /**
     * Creates the application.
     *
     * @return \Laravel\Lumen\Application
     */
    public function createApplication()
    {
        return require __DIR__ . '/../bootstrap/app.php';
    }

    protected function route($name, array $parameters = []/*, $secure = null*/)
    {
        $urls = [
            'backend.users.profile' => '/auth/profile',
            'backend.users.deleted' => '/auth/users/deleted',
            'backend.users.restore' => '/auth/users/{id}/restore',
            'backend.users.purge' => '/auth/users/{id}/purge',
            'backend.users.index' => '/auth/users',
            'backend.users.store' => '/auth/users',
            'backend.users.show' => '/auth/users/{id}',
            'backend.users.update' => '/auth/users/{id}',
            'backend.users.destroy' => '/auth/users/{id}',
            'backend.roles.index' => '/auth/roles',
            'backend.roles.store' => '/auth/roles',
            'backend.roles.show' => '/auth/roles/{id}',
            'backend.roles.update' => '/auth/roles/{id}',
            'backend.roles.destroy' => '/auth/roles/{id}',
            'backend.permissions.index' => '/auth/permissions',
            'backend.permissions.show' => '/auth/permissions/{id}',
            'backend.authorizations.assign-role-to-user' => '/auth/authorizations/assign-role-to-user',
            'backend.authorizations.revoke-role-from-user' => '/auth/authorizations/revoke-role-from-user',
            'backend.authorizations.assign-permission-to-user' => '/auth/authorizations/assign-permission-to-user',
            'backend.authorizations.revoke-permission-from-user' => '/auth/authorizations/revoke-permission-from-user',
            'backend.authorizations.attach-permission-to-role' => '/auth/authorizations/attach-permission-to-role',
            'backend.authorizations.revoke-permission-from-role' => '/auth/authorizations/revoke-permission-from-role',
        ];
        if (!isset($urls[$name])) {
            dd(__METHOD__, "route not found $name");
        }
        $uri = $urls[$name];

        foreach ($parameters as $parameter => $value) {
            $uri = str_replace('{' . $parameter . '}', $value, $uri);
        }
        return $uri;
//        return app('Dingo\Api\Routing\UrlGenerator')->version('v1')->route($name, $parameters);
    }

    /**
     * @param array $headers
     * @param bool  $isServer
     *
     * @return array
     */
    protected function addHeaders(array $headers = [], bool $isServer = false)
    {
        $headers += [
            'Accept' => 'application/x.lumen.dingo.boilerplate.v1+json',
            'Authorization' => 'Bearer xxxxx',
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
            $user = User::role(config("access.role_names.$roleName"))->first();
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
