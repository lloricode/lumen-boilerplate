<?php
/**
 * Created by PhpStorm.
 * User: Lloric Mayuga Garcia <lloricode@gmail.com>
 * Date: 11/24/18
 * Time: 3:25 PM
 */

namespace App\Repositories;

use App\Criterion\Eloquent\OnlyTrashedCriteria;
use Prettus\Repository\Contracts\CacheableInterface;
use Prettus\Repository\Eloquent\BaseRepository as BaseRepo;
use Prettus\Repository\Events\RepositoryEntityUpdated;
use Prettus\Repository\Traits\CacheableRepository;

abstract class BaseRepository extends BaseRepo implements CacheableInterface
{
    use CacheableRepository {
        paginate as protected paginateExtend;
    }

    /**
     * @param $id
     *
     * @return mixed
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function restore($id)
    {
        return $this->manageDeletes($id, 'restore');
    }

    /**
     * @param int    $id
     * @param string $method
     *
     * @return mixed
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    private function manageDeletes(int $id, string $method)
    {
        $this->applyScope();

        $temporarySkipPresenter = $this->skipPresenter;
        $this->skipPresenter(true);

        $this->pushCriteria(new OnlyTrashedCriteria);
        $model = $this->find($id);
        $originalModel = clone $model;

        $this->skipPresenter($temporarySkipPresenter);
        $this->resetModel();

        $model->{$method}();

        event(new RepositoryEntityUpdated($this, $originalModel));

        return $this->parserResult($model);
    }

    /**
     * @param int $id
     *
     * @return mixed
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function forceDelete(int $id)
    {
        return $this->manageDeletes($id, 'forceDelete');
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
        // ignore all when limit already specify
        if (!is_null($limit)) {
            return $this->paginateExtend($limit, $columns, $method);
        }

        $repoPaginationConfig = config('setting.repository');
        $requestLimit = app('request')->get('limit');

        if (!is_null($requestLimit)) {
            $limit = ($requestLimit >= 0 && $requestLimit <= $repoPaginationConfig['limit_pagination'])
                ? $requestLimit : null;
        }

        if ($limit == '0' && $repoPaginationConfig['skip_pagination'] === true) {
            return $this->all($columns);
        }

        if (!is_null($limit)) {
            $limit = (int)$limit;
        }

        return $this->paginateExtend($limit, $columns, $method);
    }
}