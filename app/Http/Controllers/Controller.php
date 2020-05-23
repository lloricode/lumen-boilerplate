<?php

namespace App\Http\Controllers;

use App\Traits\Hashable;
use App\Transformers\BaseTransformer;
use Laravel\Lumen\Routing\Controller as BaseController;
use Spatie\Fractal\Fractal;

class Controller extends BaseController
{
    use Hashable;

    /**
     * @param $data
     * @param $transformer
     *
     * @return \Spatie\Fractal\Fractal
     */
    protected function fractal($data, $transformer)
    {
        $fractal = fractal($data, $transformer)
            ->withResourceName($this->getResourceKey($transformer));

        return $this->addAvailableIncludes($fractal, $transformer);
    }

    /**
     * @param $transformer
     *
     * @return string
     */
    private function getResourceKey($transformer): string
    {
        return $this->checkTransformer($transformer)->getResourceKey();
    }

    /**
     * @param $transformer
     *
     * @return \App\Transformers\BaseTransformer
     */
    private function checkTransformer($transformer): BaseTransformer
    {
        if (is_string($transformer)) {
            $transformer = app($transformer);
        }
        return $transformer;
    }

    private function addAvailableIncludes(Fractal $response, $transformer): Fractal
    {
        return $response->addMeta('include', $this->checkTransformer($transformer)->getAvailableIncludes());
    }
}
