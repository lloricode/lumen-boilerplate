<?php

/*
|--------------------------------------------------------------------------
| Version 1
|--------------------------------------------------------------------------
|
*/

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

$router->group(
    [
        'middleware' =>
            [
                'auth',
//            'api.throttle',
//            'api.auth',
//            'serializer',
            ]
        ,
        'limit' => config('setting.api.throttle.limit'),          // api.throttle max
        'expires' => config('setting.api.throttle.expires') * 60, // api.throttle minute
    ],
    function () use ($router) {
        include 'localization.php';

        $router->group(
            [
                'namespace' => 'Frontend',
                'as' => 'frontend',
            ],
            function () use ($router) {
                include 'frontend/user/user.php';
            }
        );
        $router->group(
            [
                'namespace' => 'Backend',
                'as' => 'backend',
                'middleware' => 'permission:'.config('setting.permission.permission_names.view_backend'),
            ],
            function () use ($router) {
                $router->group(
                    [
                        'prefix' => 'auth',
                    ],
                    function () use ($router) {
                        include 'backend/auth/user.php';
                        include 'backend/auth/role.php';
                        include 'backend/auth/permission.php';
                        include 'backend/auth/authorization.php';
                        include 'backend/log.php';
                    }
                );
            }
        );
    }
);