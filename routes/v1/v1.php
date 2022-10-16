<?php

declare(strict_types=1);

/** @var Laravel\Lumen\Routing\Router $router */

$router->group(
    [
    ],
    function () use ($router) {
        include 'localization.php';
        include 'frontend/frontend.php';
        include 'backend/backend.php';
    }
);
