<?php
/**
 * Created by PhpStorm.
 * User: Lloric Mayuga Garcia <lloricode@gmail.com>
 * Date: 11/24/18
 * Time: 3:25 PM
 */

namespace App\Repositories;

use Prettus\Repository\Contracts\CacheableInterface;
use Prettus\Repository\Eloquent\BaseRepository as BaseRepo;
use Prettus\Repository\Traits\CacheableRepository;

abstract class BaseRepository extends BaseRepo implements CacheableInterface
{
    use CacheableRepository;

    /**
     * @return \Laravel\Lumen\Application|mixed
     */
    public function resolveModel()
    {
        return app($this->model());
    }

    /**
     * @param null   $limit
     * @param array  $columns
     * @param string $method
     *
     * @return mixed
     */
    public function paginate($limit = null, $columns = ['*'], $method = "paginate")
    {
        if (is_null($limit)) {
            $l = app('request')->get('limit');
            $limit = $l >= 0 ? $l : null;

            if (false && $limit == 0) {// TODO: config
                return parent::all($columns);
            }
        }

        // TODO: unit test
        return parent::paginate($limit, $columns, $method);
    }
}