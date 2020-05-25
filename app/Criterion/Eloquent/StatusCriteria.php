<?php

namespace App\Criterion\Eloquent;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class StatusCriteria implements CriteriaInterface
{

    /**
     * @var string|array
     */
    private $statusName;

    public function __construct(...$statusName)
    {
        $this->statusName = $statusName;
    }

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
        return $model->currentStatus($this->statusName);
    }
}
