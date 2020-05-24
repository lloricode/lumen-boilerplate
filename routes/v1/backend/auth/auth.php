<?php

/** @var Laravel\Lumen\Routing\Router $router */

$router->group(
    [
        'prefix' => 'auth',
    ],
    function () use ($router) {
        include 'user.php';
        include 'role.php';
        include 'permission.php';
        include 'authorization.php';
    }
);