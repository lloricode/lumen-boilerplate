<?php

declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: Lloric Mayuga Garcia <lloricode@gmail.com>
 * Date: 2/3/19
 * Time: 5:30 AM
 */

namespace App\Values\Localizations;

use App\Values\Value;
use Locale;

class Localization extends Value
{
    private ?string $language = null;

    private array $regions = [];

    /**
     * Localization constructor.
     *
     * @param       $language
     * @param  array  $regions
     */
    public function __construct($language, array $regions = [])
    {
        $this->language = $language;

        foreach ($regions as $region) {
            $this->regions[] = new Region($region);
        }
    }

    /** @return string */
    public function getDefaultName()
    {
        return Locale::getDisplayLanguage($this->language, config('app.locale'));
    }

    /** @return string */
    public function getLocaleName()
    {
        return Locale::getDisplayLanguage($this->language, $this->language);
    }

    /** @return string|null */
    public function getLanguage()
    {
        return $this->language;
    }

    /** @return array */
    public function getRegions()
    {
        return $this->regions;
    }
}
