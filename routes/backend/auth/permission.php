<?php
$api->group([
    'namespace' => 'Auth\Permission',
    'as' => 'permissions',
    'prefix' => 'permissions',
], function () use ($api) {
    // resources
    $api->get('/', [
        'as' => 'index',
        'uses' => 'PermissionController@index',
    ]);
    $api->get('/{id}', [
        'as' => 'show',
        'uses' => 'PermissionController@show',
    ]);
});