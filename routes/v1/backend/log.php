<?php

declare(strict_types=1);

/** @var Laravel\Lumen\Routing\Router $router */

$router->get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');
