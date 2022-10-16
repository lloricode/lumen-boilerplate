<?php

declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: Lloric Mayuga Garcia <lloricode@gmail.com>
 * Date: 12/13/18
 * Time: 10:03 PM
 */

use Database\Factories\Auth\User\UserFactory;

test('unique email', function () {
    $this->loggedInAs();

    $uniqueEmail = 'my@email.com';

    UserFactory::new()->create(
        [
            'email' => $uniqueEmail,
        ]
    );

    $user = UserFactory::new()->create(
        [
            'email' => 'xx'.$uniqueEmail,
        ]
    );

    put(
        'auth/users/'.self::forId($user),
        [
            'email' => $uniqueEmail,
        ],
        $this->addHeaders()
    );

    assertResponseStatus(422);
    seeJson(
        [
            'email' => ['The email has already been taken.'],
        ]
    );
});
