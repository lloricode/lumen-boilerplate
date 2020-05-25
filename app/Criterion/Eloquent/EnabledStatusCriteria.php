<?php

namespace App\Criterion\Eloquent;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class EnabledStatusCriteria implements CriteriaInterface
{

    /**
     * Apply criteria in query repository
     *
     * @param                     $model
     * @param  RepositoryInterface  $repository
     *
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
        /** @var \Illuminate\Database\Eloquent\Model|\Spatie\ModelStatus\HasStatuses $model */
        return $model->currentStatus(config('core-base.statuses.default.enable'));
    }
}
