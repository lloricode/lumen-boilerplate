<?php

namespace App\Criterion\Eloquent;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class ThisWithCriteria implements CriteriaInterface
{
    /** @var array */
    private $relations;

    public function __construct(array $relations)
    {
        $this->relations = $relations;
    }

    public function apply($model, RepositoryInterface $repository)
    {
        /** @var \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Model $model */
        return $model->with($this->relations);
    }
}
