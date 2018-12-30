<?php
/**
 * Created by PhpStorm.
 * User: Lloric Mayuga Garcia <lloricode@gmail.com>
 * Date: 12/30/18
 * Time: 9:15 AM
 */

namespace Tests;

use Laravel\Lumen\Testing\TestCase;

class BaseUrlTest extends TestCase
{
    /**
     * @test
     */
    public function base()
    {
        $this->get('/', [
            'Accept' => 'application/x.lumen.dingo.boilerplate.v1+json',
        ]);
        $this->assertResponseOk();
        $this->seeJson([
            'name' => config('app.name'),
            'branch' => 'dev-master',
        ]);
    }

    /**
     * @test
     */
    public function baseNeedsHeader()
    {
        $this->get('/');
        $this->assertResponseStatus(400);
    }

    /**
     * Creates the application.
     *
     * Needs to be implemented by subclasses.
     *
     * @return \Symfony\Component\HttpKernel\HttpKernelInterface
     */
    public function createApplication()
    {
        return require __DIR__ . '/../bootstrap/app.php';
    }
}