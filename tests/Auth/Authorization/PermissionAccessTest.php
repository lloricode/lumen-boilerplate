<?php
/**
 * Created by PhpStorm.
 * User: Lloric Mayuga Garcia <lloricode@gmail.com>
 * Date: 12/2/18
 * Time: 1:14 PM
 */

namespace Test\Auth\Authorization;

class PermissionAccessTest extends BaseRole
{
    /**
     * @param $method
     * @param $uri
     * @param $roleName
     * @param $statusCode
     *
     * @test
     * @dataProvider dataResources
     */
    public function access($method, $uri, $roleName, $statusCode)
    {
        if (!empty($roleName)) {
            $this->loggedInAs($roleName);
        }

        if ($uri == 'permissions/{id}') {
            $p = app(config('permission.models.permission'))->first();
            $uri = str_replace('{id}', $p->getHashedId(), $uri);
        }

        $this->call($method, '/auth/'.$uri, [], [], [], $this->addHeaders([], true));
        $this->assertResponseStatus($statusCode);
    }

    public function dataResources(): array
    {
        return [
            // system
            'index by system' => ['get', 'permissions', 'system', 200],
            'show by system' => ['get', 'permissions/{id}', 'system', 200],
            // admin
            'index by admin' => ['get', 'permissions', 'admin', 200],
            'show by admin' => ['get', 'permissions/{id}', 'admin', 200],
            // role none role
            'index by none role' => ['get', 'permissions', 'user', 403],
            'show by none role' => ['get', 'permissions/{id}', 'user', 403],
            // guest
            'index by guest' => ['get', 'permissions', '', 401],
            'show by guest' => ['get', 'permissions/{id}', '', 401],
        ];
    }

}