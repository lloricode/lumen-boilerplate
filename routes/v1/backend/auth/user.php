<?php

declare(strict_types=1);

/** @var Laravel\Lumen\Routing\Router $router */

$router->group(
    [
        'namespace' => 'User',
        'as' => 'users',
    ],
    function () use ($router) {
        $router->group(
            [
                'prefix' => 'users',
            ],
            function () use ($router) {
                // deletes
                $router->get(
                    '/deleted',
                    [
                        'as' => 'deleted',
                        'uses' => 'UserDeleteController@deleted',
                    ]
                );
                $router->put(
                    '/{id}/restore',
                    [
                        'as' => 'restore',
                        'uses' => 'UserDeleteController@restore',
                    ]
                );
                $router->delete(
                    '/{id}/purge',
                    [
                        'as' => 'purge',
                        'uses' => 'UserDeleteController@purge',
                    ]
                );

                // resources
                $router->get(
                    '/',
                    [
                        'as' => 'index',
                        'uses' => 'UserController@index',
                    ]
                );
                $router->post(
                    '/',
                    [
                        'as' => 'store',
                        'uses' => 'UserController@store',
                    ]
                );
                $router->get(
                    '/{id}',
                    [
                        'as' => 'show',
                        'uses' => 'UserController@show',
                    ]
                );
                $router->put(
                    '/{id}',
                    [
                        'as' => 'update',
                        'uses' => 'UserController@update',
                    ]
                );
                $router->delete(
                    '/{id}',
                    [
                        'as' => 'destroy',
                        'uses' => 'UserController@destroy',
                    ]
                );
            }
        );
    }
);
