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

    $param = [];
    if ($method === 'post' && $uri === 'roles') {
        // only param
        $param = [
            'name' => 'test role name',
        ];
    } elseif ($method === 'get' && $uri === 'roles/{id}') {
        // only uri
        $uri = $this->replaceRoleUri($uri);
    } elseif ($method === 'delete' && $uri === 'roles/{id}') {
        // only uri
        $uri = $this->replaceRoleUri($uri, $this->createRole('test role 123'));
    } elseif ($method === 'put' && $uri === 'roles/{id}') {
        // both uri and param
        $uri = $this->replaceRoleUri($uri, $this->createRole('test role 123'));
        $param = [
            'name' => 'test new role name',
        ];
    }

    call($method, '/auth/'.$uri, $param, [], [], $this->addHeaders([], true));
    assertResponseStatus($statusCode);
})->with([
    // system
    'store by system' => ['post', 'roles', 'system', 201],
    'index by system' => ['get', 'roles', 'system', 200],
    'show by system' => ['get', 'roles/{id}', 'system', 200],
    'update by system' => ['put', 'roles/{id}', 'system', 200],
    'destroy by system' => ['delete', 'roles/{id}', 'system', 204],
    // admin
    'store by admin' => ['post', 'roles', 'admin', 201],
    'index by admin' => ['get', 'roles', 'admin', 200],
    'show by admin' => ['get', 'roles/{id}', 'admin', 200],
    'update by admin' => ['put', 'roles/{id}', 'admin', 200],
    'destroy by admin' => ['delete', 'roles/{id}', 'admin', 204],
    // role none role
    'store by none role' => ['post', 'roles', 'user', 403],
    'index by none role' => ['get', 'roles', 'user', 403],
    'show by none role' => ['get', 'roles/{id}', 'user', 403],
    'update by none role' => ['put', 'roles/{id}', 'user', 403],
    'destroy by none role' => ['delete', 'roles/{id}', 'user', 403],
    // guest
    'store by guest' => ['post', 'roles', '', 401],
    'index by guest' => ['get', 'roles', '', 401],
    'show by guest' => ['get', 'roles/{id}', '', 401],
    'update by guest' => ['put', 'roles/{id}', '', 401],
    'destroy by guest' => ['delete', 'roles/{id}', '', 401],
]);
