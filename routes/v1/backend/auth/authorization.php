<?php

/** @var Laravel\Lumen\Routing\Router $router */

$router->group(
    [
        'namespace' => 'Auth\Authorization',
        'as' => 'authorizations',
        'prefix' => 'authorizations',
    ],
    function () use ($router) {
        // role - user
        $router->post(
            '/assign-role-to-user',
            [
                'as' => 'assign-role-to-user',
                'uses' => 'AuthorizationController@assignRoleToUser',
            ]
        );
        $router->post(
            '/revoke-role-from-user',
            [
                'as' => 'revoke-role-from-user',
                'uses' => 'AuthorizationController@revokeRoleFormUser',
            ]
        );

        // permission - user
        $router->post(
            '/assign-permission-to-user',
            [
                'as' => 'assign-permission-to-user',
                'uses' => 'AuthorizationController@assignPermissionToUser',
            ]
        );
        $router->post(
            '/revoke-permission-from-user',
            [
                'as' => 'revoke-permission-from-user',
                'uses' => 'AuthorizationController@revokePermissionFromUser',
            ]
        );

        // permission - role
        $router->post(
            '/attach-permission-to-role',
            [
                'as' => 'attach-permission-to-role',
                'uses' => 'AuthorizationController@attachPermissionToRole',
            ]
        );
        $router->post(
            '/revoke-permission-from-role',
            [
                'as' => 'revoke-permission-from-role',
                'uses' => 'AuthorizationController@revokePermissionFromRole',
            ]
        );
    }
);