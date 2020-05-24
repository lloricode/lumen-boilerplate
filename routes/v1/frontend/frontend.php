<?php

/** @var Laravel\Lumen\Routing\Router $router */

$router->group(
    [
        'namespace' => 'Frontend',
        'as' => 'frontend',
    ],
    function () use ($router) {
        include 'user/user.php';
    }
);
