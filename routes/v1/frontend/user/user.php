<?php

declare(strict_types=1);

/** @var Laravel\Lumen\Routing\Router $router */

$router->group(
    [
        'namespace' => 'User',
        'as' => 'users',
    ],
    function () use ($router) {
        // Access
        $router->get(
            '/profile',
            [
                'as' => 'profile',
                'uses' => 'UserAccessController@profile',
            ]
        );
    }
);
