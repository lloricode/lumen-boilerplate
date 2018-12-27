<?php
/**
 * Created by PhpStorm.
 * User: Lloric Mayuga Garcia <lloricode@gmail.com>
 * Date: 12/25/18
 * Time: 12:17 PM
 */

namespace Tests\Auth\User;

use App\Models\Auth\User\User;
use Tests\TestCase;

class DeleteResourceFailedTest extends TestCase
{
    /**
     * @test
     */
    public function purgeNoneDeletedUserWillGive404()
    {
        $this->loggedInAs();

        $user = factory(User::class)->create();

        $this->delete($this->route('backend.users.purge', ['id' => $user->getHashedId()]), [], $this->addHeaders());
        $this->assertResponseStatus(404);
    }

    /**
     * @test
     */
    public function restoreNoneDeletedUserWillGive404()
    {
        $this->loggedInAs();

        $user = factory(User::class)->create();

        $this->put($this->route('backend.users.restore', ['id' => $user->getHashedId()]), [], $this->addHeaders());
        $this->assertResponseStatus(404);
    }
}