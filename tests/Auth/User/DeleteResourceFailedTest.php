<?php

declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: Lloric Mayuga Garcia <lloricode@gmail.com>
 * Date: 12/25/18
 * Time: 12:17 PM
 */

use Database\Factories\Auth\User\UserFactory;

test('purge none deleted user will give 404', function () {
    $this->loggedInAs();

    $user = UserFactory::new()->create();

    delete(
        'auth/users/'.self::forId($user).'/purge',
        [],
        $this->addHeaders()
    );
    assertResponseStatus(404);
});

/** @test */
test('restore none deleted user will give 404', function () {
    $this->loggedInAs();

    $user = UserFactory::new()->create();

    put(
        'auth/users/'.self::forId($user).'/restore',
        [],
        $this->addHeaders()
    );
    assertResponseStatus(404);
});
