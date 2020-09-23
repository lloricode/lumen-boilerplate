<?php
/**
 * Created by PhpStorm.
 * User: Lloric Mayuga Garcia <lloricode@gmail.com>
 * Date: 12/13/18
 * Time: 10:03 PM
 */

namespace Test\Auth\User;

use Database\Factories\Auth\User\UserFactory;
use Test\TestCase;

class UserValidationTest extends TestCase
{
    /** @test */
    public function unique_email()
    {
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

        $this->put(
            route('backend.users.update', ['id' => self::forId($user)]),
            [
                'email' => $uniqueEmail,
            ],
            $this->addHeaders()
        );

        $this->assertResponseStatus(422);
        $this->seeJson(
            [
                'email' => ['The email has already been taken.'],
            ]
        );
    }
}