<?php
/**
 * Created by PhpStorm.
 * User: Lloric Mayuga Garcia <lloricode@gmail.com>
 * Date: 12/2/18
 * Time: 5:16 PM
 */

namespace Tests\Auth\User;

use Tests\TestCase;

class UserProfileTest extends TestCase
{
    /**
     * @param $roleName
     * @param $status
     *
     * @test
     * @testWith ["system", 200]
     *          ["admin", 200]
     *          ["user", 200]
     *          ["", 401]
     */
    public function getProfile($roleName, $status)
    {
        if (!empty($roleName)) {
            $this->loggedInAs($roleName);
            $user = collect(app('auth')->user())->only([
                'first_name',
                'last_name',
                'email',
            ])->toArray();
        }
        $this->get($this->route('backend.users.profile'), $this->addHeaders());

        if (!empty($roleName)) {
            $this->seeJson($user);
        }
        $this->assertResponseStatus($status);
    }
}