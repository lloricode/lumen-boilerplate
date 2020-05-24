<?php

/*
|--------------------------------------------------------------------------
| Version 1
|--------------------------------------------------------------------------
|
*/

/** @var Laravel\Lumen\Routing\Router $router */

$router->group(
    [
        'namespace' => 'V1',
        'middleware' =>
            [
                'auth',
//            'api.throttle',
//            'api.auth',
//            'serializer',
            ]
        ,
// TODO: throttle
//
//        'limit' => config('setting.api.throttle.limit'),          // api.throttle max
//        'expires' => config('setting.api.throttle.expires') * 60, // api.throttle minute
    ],
    function () use ($router) {
        include 'localization.php';
        include 'frontend/frontend.php';
        include 'backend/backend.php';
    }
);