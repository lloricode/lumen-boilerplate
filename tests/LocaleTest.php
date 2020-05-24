<?php
/**
 * Created by PhpStorm.
 * User: Lloric Mayuga Garcia <lloricode@gmail.com>
 * Date: 1/27/19
 * Time: 4:03 PM
 */

namespace Test;

use App\Models\Auth\User\User;
use Laravel\Lumen\Testing\TestCase;
use Laravel\Passport\Passport;

class LocaleTest extends TestCase
{
    /** @test */
    public function get_all()
    {
        Passport::actingAs(factory(User::class)->create());
        $this->get(
            'localizations',
            [
                'Accept' => 'application/x.lumen.boilerplate.v1+json',
                'Authorization' => 'Bearer xxxxx',
            ]
        )
            ->assertResponseOk();
    }

    /**
     * @param  string|null  $locale
     *
     * @test
     * @testWith ["en"]
     *           [null]
     *           ["xxx"]
     *           ["xxx,fr"]
     */
    public function check_all_locale(string $locale = null)
    {
        $headers = [
            'Accept' => 'application/x.lumen.boilerplate.v1+json',
        ];

        if (!is_null($locale)) {
            $headers['Accept-Language'] = $locale;
        }

        $this->get('/', $headers);

        if ($locale == 'xxx') {
            $this->assertResponseStatus(412);
            $this->seeJson(
                [
                    'message' => 'Unsupported Language.',
//                    'status_code' => 412,
                ]
            );
            return;
        }

        $message = 'Welcome to Lumen Boilerplate';
        switch ($locale) {
            case'xxx,fr';
                $locale = 'fr';
                $message = 'Bienvenue chez Lumen Boilerplate';
                break;
            default:
                $locale = $locale ?: config('app.locale');
                break;
        }
        $this->assertResponseOk();
        $this->assertEquals(app('translator')->getLocale(), $locale);
        $this->seeJson(
            [
                'message' => $message,
            ]
        );
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
        return require __DIR__.'/../bootstrap/app.php';
    }
}