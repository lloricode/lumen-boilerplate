<?php

namespace App\Http\Controllers;

use App\Traits\Hashable;
use App\Transformers\BaseTransformer;
use Closure;
use Dingo\Api\Http\Response;
use Dingo\Api\Routing\Helpers;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Collection;
use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use Hashable;
    use Helpers;

    /**
     * @param                                   $paginatorOrCollection
     * @param \App\Transformers\BaseTransformer $transformer
     * @param array                             $parameters
     * @param \Closure|null                     $after
     *
     * @return \Dingo\Api\Http\Response
     */
    protected function paginatorOrCollection(
        $paginatorOrCollection,
        BaseTransformer $transformer,
        array $parameters = [],
        Closure $after = null
    ) {
        $method = '';
        if ($paginatorOrCollection instanceof Paginator) {
            $method = 'paginator';
        } elseif ($paginatorOrCollection instanceof Collection) {
            $method = 'collection';
        }

        $parameters = $this->addResourceKey($transformer, $parameters);

        $response = $this->{$method}($paginatorOrCollection,
            $transformer,
            $parameters,
            $after
        );

        return $this->addAvailableIncludes($response, $transformer);
    }

    /**
     * @param $transformer
     * @param $parameters
     *
     * @return array
     */
    private function addResourceKey($transformer, $parameters): array
    {
        $parameters += [
            'key' => $this->checkTransformer($transformer)->getResourceKey(),
        ];
        return $parameters;
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

    /**
     * @param \Dingo\Api\Http\Response $response
     * @param                          $transformer
     *
     * @return \Dingo\Api\Http\Response
     */
    private function addAvailableIncludes(Response $response, $transformer): Response
    {
        return $response->addMeta('include', $this->checkTransformer($transformer)->getAvailableIncludes());
    }

    /**
     * @param                                   $item
     * @param \App\Transformers\BaseTransformer $transformer
     * @param array                             $parameters
     * @param \Closure|null                     $after
     *
     * @return \Dingo\Api\Http\Response
     */
    protected function item($item, $transformer, $parameters = [], Closure $after = null)
    {
        $parameters = $this->addResourceKey($transformer, $parameters);

        $response = $this->response->item($item, $transformer, $parameters, $after);
        return $this->addAvailableIncludes($response, $transformer);
    }
}
