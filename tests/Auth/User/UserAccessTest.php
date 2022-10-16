<?php

declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: Lloric Mayuga Garcia <lloricode@gmail.com>
 * Date: 12/2/18
 * Time: 1:14 PM
 */

use Database\Factories\Auth\User\UserFactory;

it('access', function ($method, $uri, $roleName, $statusCode) {
    if ( ! empty($roleName)) {
        $this->loggedInAs($roleName);
    }

    $param = [];
    if ($method === 'post' && $uri === 'users') {
        // only param
        $param = $this->userData();
    } elseif ($method === 'get' && $uri === 'users/{id}' ||
        $method === 'delete' && $uri === 'users/{id}') {
        // only uri
        $uri = replaceUserUri($uri);
    } elseif ($method === 'put' && $uri === 'users/{id}/restore' ||
        $method === 'delete' && $uri === 'users/{id}/purge') {
        // only uri
        $uri = replaceUserUri($uri, true);
    } elseif ($method === 'put' && $uri === 'users/{id}') {
        // both uri and param
        $uri = replaceUserUri($uri);
        $param = $this->userData();
    }

    call($method, '/auth/'.$uri, $param, [], [], $this->addHeaders([], true));
    assertResponseStatus($statusCode);
})
    ->with([
        // system
        'store by system' => ['post', 'users', 'system', 201],
        'index by system' => ['get', 'users', 'system', 200],
        'show by system' => ['get', 'users/{id}', 'system', 200],
        'update by system' => ['put', 'users/{id}', 'system', 200],
        'deleted list by system' => ['get', 'users/deleted', 'system', 200],
        'destroy by system' => ['delete', 'users/{id}', 'system', 204],
        'restore by system' => ['put', 'users/{id}/restore', 'system', 200],
        'purge by system' => ['delete', 'users/{id}/purge', 'system', 204],
        // admin
        'store by admin' => ['post', 'users', 'admin', 201],
        'index by admin' => ['get', 'users', 'admin', 200],
        'show by admin' => ['get', 'users/{id}', 'admin', 200],
        'update by admin' => ['put', 'users/{id}', 'admin', 200],
        'deleted list by admin' => ['get', 'users/deleted', 'admin', 200],
        'destroy by admin' => ['delete', 'users/{id}', 'admin', 204],
        'restore by admin' => ['put', 'users/{id}/restore', 'admin', 200],
        'purge by admin' => ['delete', 'users/{id}/purge', 'admin', 204],
        // user none role
        'store by none role' => ['post', 'users', 'user', 403],
        'index by none role' => ['get', 'users', 'user', 403],
        'show by none role' => ['get', 'users/{id}', 'user', 403],
        'update by none role' => ['put', 'users/{id}', 'user', 403],
        'deleted list by none role' => ['get', 'users/deleted', 'user', 403],
        'destroy by none role' => ['delete', 'users/{id}', 'user', 403],
        'restore by none role' => ['put', 'users/{id}/restore', 'user', 403],
        'purge by none role' => ['delete', 'users/{id}/purge', 'user', 403],
        // guest
        'store by guest' => ['post', 'users', '', 401],
        'index by guest' => ['get', 'users', '', 401],
        'show by guest' => ['get', 'users/{id}', '', 401],
        'update by guest' => ['put', 'users/{id}', '', 401],
        'deleted list by guest' => ['get', 'users/deleted', '', 401],
        'destroy by guest' => ['delete', 'users/{id}', '', 401],
        'restore by guest' => ['put', 'users/{id}/restore', '', 401],
        'purge by guest' => ['delete', 'users/{id}/purge', '', 401],
    ]);

function replaceUserUri($uri, bool $isDeleted = false): string
{
    $user = UserFactory::new()->create();
    if ($isDeleted) {
        $user->delete();
    }
    return str_replace('{id}', test()->forId($user), $uri);
}
