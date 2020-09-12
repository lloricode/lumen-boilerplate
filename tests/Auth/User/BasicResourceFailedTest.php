<?php

namespace Test\Auth\User;

use App\Models\Auth\User\User;
use Test\TestCase;

class BasicResourceFailedTest extends TestCase
{
    /** @test */
    public function cannot_delete_self()
    {
        $user = $this->loggedInAs();

        $this->delete(route('backend.users.destroy', ['id' => self::forId($user)]), [], $this->addHeaders());

        $this->assertResponseStatus(403);
        $this->seeJson(
            [
                'message' => 'You cannot delete your self.',
            ]
        );
    }

//    /**
//     * @param $environment
//     *
//     * @test
//     * @testWith ["production"]
//     *      ["local"]
//     */
//    public function get_user_with_wrong_hashed_dd($environment)
//    {
//        putenv("APP_ENV=$environment");
//        $this->loggedInAs();
//
//        $hashedId = self::forId(factory(User::class)->create());
//
//        // remove last char
//        $id = substr($hashedId, 0, strlen($hashedId) - 1);
//
//        $this->get(route('backend.users.show', ['id' => $id]), $this->addHeaders());
//        $this->assertResponseStatus(400);
//        $this->seeJson(
//            [
//                'message' =>
////                $environment == 'production'
////                ? Response::$statusTexts[Response::HTTP_NOT_FOUND]
////                :
//                    'Invalid hashed id.',
//            ]
//        );
//    }

    /** @test
     * @throws \Exception
     */
    public function get_none_existed_user()
    {
        $this->loggedInAs();

        $user = factory(User::class)->create();

        $hashedId = self::forId($user);

        $user->delete();

        $this->get(route('backend.users.show', ['id' => $hashedId]), $this->addHeaders());
        $this->assertResponseStatus(404);
    }
}
