<?php

namespace App\Http\Controllers;

use App\Traits\Hashable;
use App\Transformers\BaseTransformer;
use Laravel\Lumen\Routing\Controller as BaseController;
use Spatie\Fractal\Fractal;

//use Illuminate\Http\Request;
//use Dingo\Api\Routing\Helpers;

class Controller extends BaseController
{
    use Hashable;

//    use Helpers;

    /**
     * @param $data
     * @param $transformer
     *
     * @return \Spatie\Fractal\Fractal
     */
    protected function fractal($data, $transformer)
    {
//        $method = '';
//        if ($paginatorOrCollection instanceof Paginator) {
//            $method = 'paginator';
//        } elseif ($paginatorOrCollection instanceof Collection OR $paginatorOrCollection instanceof SupportCollection) {
//            $method = 'collection';
//        }

//        $parameters = $this->addResourceKey($transformer, $parameters);

//        $response = $this->{$method}(
//            $paginatorOrCollection,
//            $transformer,
//            $parameters,
//            $after
//        );

        $fractal = fractal($data, $transformer)
            ->withResourceName($this->getResourceKey($transformer));

        return $this->addAvailableIncludes($fractal, $transformer);
    }

//    /**
//     * @param $item
//     * @param $transformer
//     * @param  array  $parameters
//     * @param  \Closure|null  $after
//     *
//     * @return \Spatie\Fractal\Fractal
//     */
//    protected function item($item, $transformer, $parameters = [], Closure $after = null)
//    {
//        return fractal($item, $transformer);
//    }

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
