<?php
/**
 * Created by PhpStorm.
 * User: Lloric Mayuga Garcia <lloricode@gmail.com>
 * Date: 12/2/18
 * Time: 5:16 PM
 */

namespace Test\Auth\User;

use Test\TestCase;

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
    public function get_profile($roleName, $status)
    {
        if (!empty($roleName)) {
            $userData = collect($this->loggedInAs($roleName))->only(
                [
                    'first_name',
                    'last_name',
                    'email',
                ]
            )->toArray();
        }
        $this->get($this->route('frontend.users.profile'), $this->addHeaders());

        if (!empty($roleName)) {
            $this->seeJson($userData);
        }
        $this->assertResponseStatus($status);
    }
}