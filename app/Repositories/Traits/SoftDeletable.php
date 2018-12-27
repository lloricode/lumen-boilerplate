<?php
/**
 * Created by PhpStorm.
 * User: Lloric Mayuga Garcia <lloricode@gmail.com>
 * Date: 12/4/18
 * Time: 8:15 PM
 */

namespace App\Repositories\Traits;

use App\Criterion\Eloquent\OnlyTrashedCriteria;
use Prettus\Repository\Events\RepositoryEntityUpdated;

trait SoftDeletable
{
    /**
     * @param int $id
     *
     * @return mixed
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
     */
    public function forceDelete(int $id)
    {
        return $this->manageDeletes($id, 'forceDelete');
    }
}