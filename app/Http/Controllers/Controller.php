<?php

namespace App\Http\Controllers;

use App\Traits\Hashable;
use Closure;
use Dingo\Api\Routing\Helpers;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Collection;
use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use Hashable;
    use Helpers;

    /**
     * @param               $paginatorOrCollection
     * @param               $transformer
     * @param array         $parameters
     * @param \Closure|null $after
     *
     * @return mixed
     */
    protected function paginatorOrCollection(
        $paginatorOrCollection,
        $transformer,
        array $parameters = [],
        Closure $after = null
    ) {
        $method = '';
        if ($paginatorOrCollection instanceof Paginator) {
            $method = 'paginator';
        } elseif ($paginatorOrCollection instanceof Collection) {
            $method = 'collection';
        }

        return $this->response->{$method}($paginatorOrCollection,
            $transformer,
            $parameters,
            $after
        );
    }
}
