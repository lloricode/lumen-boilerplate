<?php

/** @var Laravel\Lumen\Routing\Router $router */

$router->get(
    '/',
    function () {
        return [
            'message' => trans('messages.welcome'),
            'branch' => 'dev-master',
        ];
    }
);

require 'v1/api.php';