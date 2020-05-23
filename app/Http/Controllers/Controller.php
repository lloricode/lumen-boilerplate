<?php

namespace App\Http\Controllers;

use App\Traits\Hashable;
use App\Transformers\BaseTransformer;
use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use Hashable;

    /**
     * @param $data
     * @param  \App\Transformers\BaseTransformer  $transformer
     *
     * @return \Spatie\Fractal\Fractal
     */
    protected function fractal($data, BaseTransformer $transformer)
    {
        return fractal($data, $transformer)
            ->withResourceName($transformer->getResourceKey())
            ->addMeta('include', $transformer->getAvailableIncludes());
    }
}
