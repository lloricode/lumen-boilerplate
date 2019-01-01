<?php
$api->group([
    'namespace' => 'Auth\User',
    'as' => 'users',
], function () use ($api) {

    $api->group([
        'prefix' => 'users',
    ], function () use ($api) {

        // deletes
        $api->get('/deleted', [
            'as' => 'deleted',
            'uses' => 'UserDeleteController@deleted',
        ]);
        $api->put('/{id}/restore', [
            'as' => 'restore',
            'uses' => 'UserDeleteController@restore',
        ]);
        $api->delete('/{id}/purge', [
            'as' => 'purge',
            'uses' => 'UserDeleteController@purge',
        ]);

        // resources
        $api->get('/', [
            'as' => 'index',
            'uses' => 'UserController@index',
        ]);
        $api->post('/', [
            'as' => 'store',
            'uses' => 'UserController@store',
        ]);
        $api->get('/{id}', [
            'as' => 'show',
            'uses' => 'UserController@show',
        ]);
        $api->put('/{id}', [
            'as' => 'update',
            'uses' => 'UserController@update',
        ]);
        $api->delete('/{id}', [
            'as' => 'destroy',
            'uses' => 'UserController@destroy',
        ]);
    });
});