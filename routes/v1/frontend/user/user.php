<?php

$api->group(
    [
        'namespace' => 'User',
        'as' => 'users',
    ],
    function () use ($api) {
// Access
        $api->get(
            '/profile',
            [
                'as' => 'profile',
                'uses' => 'UserAccessController@profile',
            ]
        );
    }
);