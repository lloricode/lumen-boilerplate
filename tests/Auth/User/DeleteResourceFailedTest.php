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

    delete(route('backend.users.purge', ['id' => self::forId($user)]), [], $this->addHeaders());
    assertResponseStatus(404);
});

/** @test */
test('restore none deleted user will give 404', function () {
    $this->loggedInAs();

    $user = UserFactory::new()->create();

    put(route('backend.users.restore', ['id' => self::forId($user)]), [], $this->addHeaders());
    assertResponseStatus(404);
});
