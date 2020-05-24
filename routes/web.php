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

require 'v1/v1.php';