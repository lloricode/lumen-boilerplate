<?php

declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: Lloric Mayuga Garcia <lloricode@gmail.com>
 * Date: 12/25/18
 * Time: 12:11 PM
 */

use App\Models\Auth\User\User;
use Database\Factories\Auth\User\UserFactory;

it('store user', function () {
    $this->loggedInAs();

    post('auth/users', $this->userData(), $this->addHeaders());
    assertResponseStatus(201);

    $data = $this->userData();
    unset($data['password']);

    seeInDatabase((new User())->getTable(), $data);
    seeJson($data);
});

it('update user', function () {
    $this->loggedInAs();

    $user = UserFactory::new()->create();

    put(
        'auth/users/'.self::forId($user),
        $this->userData(),
        $this->addHeaders()
    );
    assertResponseOk();

    $data = $this->userData();
    unset($data['password']);

    seeInDatabase((new User())->getTable(), array_merge($data, ['id' => $user->getKey()]));
    seeJson($data);
});

it('destroy user', function () {
    $this->loggedInAs();

    $user = UserFactory::new()->create();

    delete(
        'auth/users/'.self::forId($user),
        [],
        $this->addHeaders()
    );
    assertResponseStatus(204);

    notSeeInDatabase(
        (new User())->getTable(),
        [
            'id' => $user->id,
            'deleted_at' => null,
        ]
    );
});

it('show user', function () {
    $this->loggedInAs();
    $user = UserFactory::new()->create($this->userData());

    get(
        'auth/users/'.self::forId($user),
        $this->addHeaders()
    );

    assertResponseOk();
    $data = $this->userData();
    unset($data['password']);
    seeJson($data);
});
