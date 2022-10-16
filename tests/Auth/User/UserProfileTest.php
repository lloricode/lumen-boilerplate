<?php

declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: Lloric Mayuga Garcia <lloricode@gmail.com>
 * Date: 12/2/18
 * Time: 5:16 PM
 */

test('get profile', function ($roleName, $status) {
    if ( ! empty($roleName)) {
        $userData = collect($this->loggedInAs($roleName))->only(
            [
                'first_name',
                'last_name',
                'email',
            ]
        )->toArray();
    }
    get('profile', $this->addHeaders());

    if ( ! empty($roleName)) {
        seeJson($userData);
    }
    assertResponseStatus($status);
})
    ->with([
        ['system', 200],
        ['admin', 200],
        ['user', 200],
        ['', 401],
    ]);
