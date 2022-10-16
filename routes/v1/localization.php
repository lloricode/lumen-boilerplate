<?php

declare(strict_types=1);

/** @var Laravel\Lumen\Routing\Router $router */

$router->get(
    '/localizations',
    [
        'uses' => 'LocalizationController@index',
    ]
);
