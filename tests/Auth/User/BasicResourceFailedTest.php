<?php

declare(strict_types=1);

use Database\Factories\Auth\User\UserFactory;

/** @test */
it('cannot_delete_self', function () {
    $user = $this->loggedInAs();

    $this->delete(
        'auth/users/'. self::forId($user),
        [],
        $this->addHeaders()
    );

    assertResponseStatus(403);
    seeJson(
        [
            'message' => 'You cannot delete your self.',
        ]
    );
});

it('get none existed user', function () {
    $this->loggedInAs();

    $user = UserFactory::new()->create();

    $hashedId = self::forId($user);

    $user->delete();

    get('auth/users/'.$hashedId, $this->addHeaders());
    assertResponseStatus(404);
});
