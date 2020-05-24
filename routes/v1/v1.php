<?php

/** @var Laravel\Lumen\Routing\Router $router */

$router->group(
    [
        'middleware' =>
            [
                'auth',
//            'api.throttle',
//            'api.auth',
//            'serializer',
            ],
    ],
    function () use ($router) {
        include 'localization.php';
        include 'frontend/frontend.php';
        include 'backend/backend.php';
    }
);