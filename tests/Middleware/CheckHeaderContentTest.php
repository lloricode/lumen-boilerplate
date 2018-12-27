<?php
/**
 * Created by PhpStorm.
 * User: Lloric Mayuga Garcia <lloricode@gmail.com>
 * Date: 12/26/18
 * Time: 3:11 PM
 */

namespace Tests\Middleware;

use Tests\TestCase;

class CheckHeaderContentTest extends TestCase
{
    /**
     * @test
     */
    public function missingAccept()
    {
        $this->loggedInAs();
        $this->get($this->route('backend.users.index'));
        $this->assertResponseStatus(400);
        $this->seeJson([
            'message' => 'Your request header must contain [Accept = application/json].',
        ]);
    }

    /**
     * @test
     */
    public function invalidAccept()
    {
        $this->loggedInAs();
        $this->get($this->route('backend.users.index'), ['Accept' => 'xxx']);
        $this->assertResponseStatus(400);
        $this->seeJson([
            'message' => 'Your request header must contain [Accept = application/json].',
        ]);
    }
}