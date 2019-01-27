<?php
/**
 * Created by PhpStorm.
 * User: Lloric Mayuga Garcia <lloricode@gmail.com>
 * Date: 1/27/19
 * Time: 4:03 PM
 */

namespace Tests;

use Laravel\Lumen\Testing\TestCase;

class LocaleTest extends TestCase
{
    /**
     * @param string|null $locale
     *
     * @test
     * @testWith ["en"]
     *           [null]
     *           ["xxx"]
     *           ["xxx,fr"]
     */
    public function checkAllLocale(string $locale = null)
    {
        $headers = [
            'Accept' => 'application/x.lumen.dingo.boilerplate.v1+json',
        ];

        if (!is_null($locale)) {
            $headers['Accept-Language'] = $locale;
        }

        $this->get('/', $headers);

        if ($locale == 'xxx') {
            $this->assertResponseStatus(412);
            $this->seeJson([
                'message' => 'Unsupported Language.',
                'status_code' => 412,
            ]);
            return;
        }

        $message = 'Welcome to Lumen 5.7 Dingo Boilerplate';
        switch ($locale) {
            case'xxx,fr';
                $locale = 'fr';
                $message = 'Bienvenue chez Lumen 5.7 Dingo Boilerplate';
                break;
            default:
                $locale = $locale ?: config('app.locale');
                break;
        }
        $this->assertResponseOk();
        $this->assertEquals(app('translator')->getLocale(), $locale);
        $this->seeJson([
            'message' => $message,
            'branch' => 'dev-master',
        ]);
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