<?php

/** @var Laravel\Lumen\Routing\Router $router */

$router->group(
    [
        'namespace' => 'Permission',
        'as' => 'permissions',
        'prefix' => 'permissions',
    ],
    function () use ($router) {
        // resources
        $router->get(
            '/',
            [
                'as' => 'index',
                'uses' => 'PermissionController@index',
            ]
        );
        $router->get(
            '/{id}',
            [
                'as' => 'show',
                'uses' => 'PermissionController@show',
            ]
        );
    }
);