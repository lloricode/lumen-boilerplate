<?php

namespace App\Criterion\Eloquent;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class ThisLimitCriteria implements CriteriaInterface
{
    private $limit;

    public function __construct(int $limit = 10)
    {
        $this->limit = $limit;
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
        /** @var \Illuminate\Database\Query\Builder $model */
        return $model->limit($this->limit);
    }
}
