<?php

declare(strict_types=1);

/** @var Laravel\Lumen\Routing\Router $router */

$router->group(
    [
        'namespace' => 'Frontend',
        'as' => 'frontend',
        'middleware' => [
            'auth',
            //            'api.throttle',
            //            'api.auth',
            //            'serializer',
        ],
    ],
    function () use ($router) {
        include 'user/user.php';
    }
);
