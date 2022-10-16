<?php

declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: Lloric Mayuga Garcia <lloricode@gmail.com>
 * Date: 2/3/19
 * Time: 5:32 AM
 */

namespace App\Values\Localizations;

use App\Values\Value;
use Locale;

class Region extends Value
{
    private ?string $region = null;

    /**
     * Region constructor.
     *
     * @param $region
     */
    public function __construct($region)
    {
        $this->region = $region;
    }

    /** @return string */
    public function getDefaultName()
    {
        return Locale::getDisplayRegion($this->region, config('app.locale'));
    }

    /** @return string */
    public function getLocaleName()
    {
        return Locale::getDisplayRegion($this->region, $this->region);
    }

    /** @return string|null */
    public function getRegion()
    {
        return $this->region;
    }
}
