<?php

/*
|--------------------------------------------------------------------------
| Version 1
|--------------------------------------------------------------------------
|
*/

$api->get('/', function () {
    return [
        'name' => config('app.name'),
        'branch' => 'dev-master',
    ];
});

$api->group([
    'middleware' => [
        'api.throttle',
        'api.auth',
        'serializer:json_api',
    ],
    'limit' => config('setting.api.throttle.limit'), // api.throttle max
    'expires' => config('setting.api.throttle.expires'), // api.throttle minute
], function () use ($api) {

    $api->group([
        'namespace' => 'Backend',
        'as' => 'backend',
    ], function () use ($api) {

        $api->group([
            'prefix' => 'auth',
        ], function () use ($api) {
            include 'backend/auth/user.php';
            include 'backend/auth/role.php';
            include 'backend/auth/permission.php';
            include 'backend/auth/authorization.php';
        });
    });
});