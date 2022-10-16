<?php

declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: Lloric Mayuga Garcia <lloricode@gmail.com>
 * Date: 1/27/19
 * Time: 4:03 PM
 */

use function PHPUnit\Framework\assertEquals;

test('get all', function () {
    //   login();
    get(
        'localizations',
        [
            'Accept' => 'application/x.lumen.boilerplate.v1+json',
            'Authorization' => 'Bearer xxxxx',
        ]
    )
        ->assertResponseOk();
});

it('check all locale', function (string $locale = null) {
    $headers = [
        'Accept' => 'application/x.lumen.boilerplate.v1+json',
    ];

    if ( ! is_null($locale)) {
        $headers['Accept-Language'] = $locale;
    }

    get('/', $headers);

    if ($locale == 'xxx') {
        assertResponseStatus(412);
        seeJson(
            [
                'message' => 'Unsupported Language.',
                //                    'status_code' => 412,
            ]
        );
        return;
    }

    $message = 'Welcome to Lumen Boilerplate';
    switch ($locale) {
        case'xxx,fr':
        $locale = 'fr';
        $message = 'Bienvenue chez Lumen Boilerplate';
        break;
        default:
            $locale = $locale ?: config('app.locale');
            break;
    }
    assertResponseOk();
    assertEquals(app('translator')->getLocale(), $locale);
    seeJson(
        [
            'message' => $message,
        ]
    );
})
    ->with([
        ['en'],
        [null],
        ['xxx'],
        ['xxx,fr'],
    ]);
