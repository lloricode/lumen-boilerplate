<?php

return [
    'permission' => [
        'role_names' => [
            'system' => 'system',
            'admin' => 'admin',
        ],
        'permission_names' => [
            'view_backend' => 'view backend',
            'manage_authorization' => 'manage authorization',
        ],
    ],

    'api' => [
        'throttle' => [
            'expires' => 1,
            'limit' => 30,
        ],
        'token' => [
            'access_token_expire' => 60 * 24, // 1day
            'refresh_token_expire' => 60 * 24 * 2, // 2days
        ]
    ],

    'formats' => [
        'date' => 'd/m/Y',
        'time_12' => 'h:i:s A',
        'time_24' => 'H:i:s',
        'datetime_12' => 'd/m/Y h:i:s A',
        'datetime_24' => 'd/m/Y H:i:s',
    ],
];
