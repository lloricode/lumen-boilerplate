<?php

/** @var Laravel\Lumen\Routing\Router $router */

$router->group(
    [
        'namespace' => 'Backend',
        'as' => 'backend',
        'middleware' => 'permission:'.config('setting.permission.permission_names.view_backend'),
    ],
    function () use ($router) {
        include 'auth/auth.php';
        include 'log.php';
    }
);