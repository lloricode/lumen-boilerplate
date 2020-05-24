<?php

/** @var Laravel\Lumen\Routing\Router $router */

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
        // TODO: throttle
        //
        // 'limit' => config('setting.api.throttle.limit'),          // api.throttle max
        // 'expires' => config('setting.api.throttle.expires') * 60, // api.throttle minute
    ],
    function () use ($router) {
        require 'v1/v1.php';
    }
);