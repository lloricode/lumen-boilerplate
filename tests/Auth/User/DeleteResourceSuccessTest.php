<?php
/**
 * Created by PhpStorm.
 * User: Lloric Mayuga Garcia <lloricode@gmail.com>
 * Date: 12/25/18
 * Time: 12:15 PM
 */

namespace Test\Auth\User;

use App\Models\Auth\User\User;
use Test\TestCase;

class DeleteResourceSuccessTest extends TestCase
{
    /** @test */
    public function restore_user()
    {
        $this->loggedInAs();

        $user = factory(User::class)->create();
        $user->delete();

        $this->put(route('backend.users.restore', ['id' => self::forId($user)]), [], $this->addHeaders());
        $this->assertResponseStatus(200);

        $this->seeInDatabase(
            (new User())->getTable(),
            [
                'id' => $user->id,
                'deleted_at' => null,
            ]
        );

        $data = $user->fresh()->toArray();
        $this->seeJson(
            [
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'email' => $data['email'],
            ]
        );
    }

    /** @test */
    public function purge_user()
    {
        $this->loggedInAs();

        $user = factory(User::class)->create();
        $user->delete();

        $this->delete(route('backend.users.purge', ['id' => self::forId($user)]), [], $this->addHeaders());
        $this->assertResponseStatus(204);

        $this->notSeeInDatabase(
            (new User())->getTable(),
            [
                'id' => $user->id,
            ]
        );
    }

}