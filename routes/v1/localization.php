<?php

/** @var Laravel\Lumen\Routing\Router $router */

$router->get(
    '/localizations',
    [
        'uses' => 'LocalizationController@index',
    ]
);