<?php

declare(strict_types=1);

/** @var Laravel\Lumen\Routing\Router $router */

$router->group(
    [
        'namespace' => 'Role',
        'as' => 'roles',
        'prefix' => 'roles',
    ],
    function () use ($router) {
        // resources
        $router->get(
            '/',
            [
                'as' => 'index',
                'uses' => 'RoleController@index',
            ]
        );
        $router->post(
            '/',
            [
                'as' => 'store',
                'uses' => 'RoleController@store',
            ]
        );
        $router->get(
            '/{id}',
            [
                'as' => 'show',
                'uses' => 'RoleController@show',
            ]
        );
        $router->put(
            '/{id}',
            [
                'as' => 'update',
                'uses' => 'RoleController@update',
            ]
        );
        $router->delete(
            '/{id}',
            [
                'as' => 'destroy',
                'uses' => 'RoleController@destroy',
            ]
        );
    }
);
