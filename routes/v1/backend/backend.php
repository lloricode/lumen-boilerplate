<?php

declare(strict_types=1);

/** @var Laravel\Lumen\Routing\Router $router */

$router->group(
    [
        'middleware' => [
            'auth',
            'permission:'.config('setting.permission.permission_names.view_backend'),
            //            'api.throttle',
            //            'api.auth',
            //            'serializer',
        ],
        'namespace' => 'Backend',
        'as' => 'backend',
    ],
    function () use ($router) {
        include 'auth/auth.php';
        include 'log.php';
    }
);
