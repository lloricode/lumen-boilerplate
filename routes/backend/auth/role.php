<?php
$api->group([
    'namespace' => 'Auth\Role',
    'as' => 'roles',
    'prefix' => 'roles',
], function () use ($api) {
    // resources
    $api->get('/', [
        'as' => 'index',
        'uses' => 'RoleController@index',
    ]);
    $api->post('/', [
        'as' => 'store',
        'uses' => 'RoleController@store',
    ]);
    $api->get('/{id}', [
        'as' => 'show',
        'uses' => 'RoleController@show',
    ]);
    $api->put('/{id}', [
        'as' => 'update',
        'uses' => 'RoleController@update',
    ]);
    $api->delete('/{id}', [
        'as' => 'destroy',
        'uses' => 'RoleController@destroy',
    ]);
});