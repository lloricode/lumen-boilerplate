<?php

declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: Lloric Mayuga Garcia <lloricode@gmail.com>
 * Date: 12/30/18
 * Time: 9:15 AM
 */

test('base', function () {
    get(
        '/',
        [
            'Accept' => 'application/json',
        ]
    );
    assertResponseOk();
    seeJson(
        [
            'message' => 'Welcome to Lumen Boilerplate',
        ]
    );
});
