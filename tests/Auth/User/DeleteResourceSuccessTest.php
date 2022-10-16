<?php

declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: Lloric Mayuga Garcia <lloricode@gmail.com>
 * Date: 12/25/18
 * Time: 12:15 PM
 */

use App\Models\Auth\User\User;
use Database\Factories\Auth\User\UserFactory;

it('restore user', function () {
    $this->loggedInAs();

    $user = UserFactory::new()->create();
    $user->delete();

    put(
        'auth/users/'.self::forId($user).'/restore',
        [],
        $this->addHeaders()
    );
    assertResponseStatus(200);

    seeInDatabase(
        (new User())->getTable(),
        [
            'id' => $user->id,
            'deleted_at' => null,
        ]
    );

    $data = $user->fresh()->toArray();
    seeJson(
        [
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
        ]
    );
});

it('purge user', function () {
    $this->loggedInAs();

    $user = UserFactory::new()->create();
    $user->delete();

    delete(
        'auth/users/'.self::forId($user).'/purge',
        [],
        $this->addHeaders()
    );
    assertResponseStatus(204);

    notSeeInDatabase(
        (new User())->getTable(),
        [
            'id' => $user->id,
        ]
    );
});
