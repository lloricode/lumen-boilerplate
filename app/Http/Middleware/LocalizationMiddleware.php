<?php

declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: Lloric Mayuga Garcia <lloricode@gmail.com>
 * Date: 1/27/19
 * Time: 11:54 AM
 */

namespace App\Http\Middleware;

use ArrayIterator;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class LocalizationMiddleware
 *
 * @package App\Http\Middleware
 * @reference https://github.com/apiato/apiato/blob/master/app/Containers/Localization/Middlewares/LocalizationMiddleware.php
 */
class LocalizationMiddleware
{
    /**
     * @param  \Illuminate\Http\Request  $request
     * @param  Closure  $next
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $locale = $this->validateLanguage($this->getLocale($request));

        if (is_null($locale)) {
            // we have not found any language that is supported
            abort(Response::HTTP_PRECONDITION_FAILED, 'Unsupported Language.');
        }

        app('translator')->setLocale($locale);

        $response = $next($request);
        $response->headers->set('Content-Language', $locale);
        return $response;
    }

    /**
     * @param $requestLanguages
     *
     * @return mixed
     */
    private function validateLanguage($requestLanguages)
    {
        /*
         * be sure to check $lang of the format "de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4"
         * this means:
         *  1) give me de-DE if it is available
         *  2) otherwise, give me de
         *  3) otherwise, give me en-US
         *  4) if all fails, give me en
        */

        // split it up by ","
        $languages = explode(',', $requestLanguages);

        // we need an ArrayIterator because we will be extending the FOREACH below dynamically!
        $language_iterator = new ArrayIterator($languages);

        $supported_languages = $this->getSupportedLanguages();

        foreach ($language_iterator as $language) {
            // split it up by ";"
            $locale = explode(';', $language);

            $current_locale = $locale[0];

            // now check, if this locale is "supported"
            if (array_search($current_locale, $supported_languages) !== false) {
                return $current_locale;
            }

            // now check, if the language to be checked is in the form of de-DE
            if (Str::contains($current_locale, '-')) {
                // extract the "main" part ("de") and append it to the end of the languages to be checked
                $base = explode('-', $current_locale);
                $language_iterator[] = $base[0];
            }
        }
        return null;
    }

    /** @return array */
    private function getSupportedLanguages()
    {
        $supported_locales = [];

        $locales = config('localization.supported_languages');

        foreach ($locales as $key => $value) {
            // it is a "simple" language code (e.g., "en")!
            if ( ! is_array($value)) {
                $supported_locales[] = $value;
            }

            // it is a combined language-code (e.g., "en-US")
            if (is_array($value)) {
                foreach ($value as $k => $v) {
                    $supported_locales[] = $v;
                }
                $supported_locales[] = $key;
            }
        }

        return $supported_locales;
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     *
     * @return string
     */
    private function getLocale(Request $request): string
    {
        return $request->hasHeader('Accept-Language')
            ? $request->header('Accept-Language')
            : config('app.locale');
    }
}
