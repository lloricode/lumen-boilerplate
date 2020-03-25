<?php

/*
|--------------------------------------------------------------------------
| Version 1
|--------------------------------------------------------------------------
|
*/

$api->get(
    '/',
    function () {
        return [
            'message' => trans('messages.welcome'),
            'branch' => 'dev-master',
        ];
    }
);

$api->group(
    [
        'middleware' => [
            'api.throttle',
            'api.auth',
            'serializer',
        ],
        'limit' => config('setting.api.throttle.limit'), // api.throttle max
        'expires' => config('setting.api.throttle.expires') * 60, // api.throttle minute
    ],
    function () use ($api) {
        include 'localization.php';

        $api->group(
            [
                'namespace' => 'Frontend',
                'as' => 'frontend',
            ],
            function () use ($api) {
                include 'frontend/user/user.php';
            }
        );
        $api->group(
            [
                'namespace' => 'Backend',
                'as' => 'backend',
                'middleware' => 'permission:'.config('setting.permission.permission_names.view_backend'),
            ],
            function () use ($api) {
                $api->group(
                    [
                        'prefix' => 'auth',
                    ],
                    function () use ($api) {
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