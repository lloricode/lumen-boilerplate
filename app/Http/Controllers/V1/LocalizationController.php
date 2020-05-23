<?php
/**
 * Created by PhpStorm.
 * User: Lloric Mayuga Garcia <lloricode@gmail.com>
 * Date: 2/3/19
 * Time: 5:22 AM
 */

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Transformers\LocalizationTransformer;
use App\Values\Localizations\Localization;

/**
 * Class LocalizationController
 *
 * @package App\Http\Controllers\V1
 */
class LocalizationController extends Controller
{
    /**
     * @return \Spatie\Fractal\Fractal
     * @api                {get} /localizations Get all localizations
     * @apiName            get-all-localizations
     * @apiGroup           Localization
     * @apiVersion         1.0.0
     * @apiPermission      Authenticated User
     * @apiUse             LocalizationsResponse
     *
     */
    public function index()
    {
        $localizations = collect();

        foreach (config('localization.supported_languages') as $key => $value) {
            // it is a simple key
            if (!is_array($value)) {
                $localizations->push(new Localization($value));
            } else { // it is a composite key
                $localizations->push(new Localization($key, $value));
            }
        }

        return $this->fractal($localizations, new LocalizationTransformer());
    }
}