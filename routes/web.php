<?php

declare(strict_types=1);

/** @var Laravel\Lumen\Routing\Router $router */

$router->group(
    [
        'middleware' => 'throttle:30,30', // limit/time(minute)
    ],
    function () use ($router) {
        $router->get(
            '/',
            function () {
                return [
                    'message' => trans('messages.welcome'),
                ];
            }
        );

        $router->group(
            [
                'namespace' => 'V1',
            ],
            function () use ($router) {
                require 'v1/v1.php';
            }
        );
    }
);
