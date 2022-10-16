<?php

declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: Lloric Mayuga Garcia <lloricode@gmail.com>
 * Date: 12/2/18
 * Time: 1:14 PM
 */

uses(Test\Auth\Authorization\BaseRole::class);

it('access', function ($method, $uri, $roleName, $statusCode) {
    if ( ! empty($roleName)) {
        $this->loggedInAs($roleName);
    }

    if ($uri == 'permissions/{id}') {
        /** @var \App\Models\Auth\Permission\Permission $p */
        $p = app(config('permission.models.permission'))->first();
        $uri = str_replace('{id}', self::forId($p), $uri);
    }

    call($method, '/auth/'.$uri, [], [], [], $this->addHeaders([], true));
    assertResponseStatus($statusCode);
})
    ->with([
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
    ]);
