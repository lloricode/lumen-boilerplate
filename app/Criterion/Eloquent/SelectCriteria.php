<?php

namespace App\Criterion\Eloquent;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class SelectCriteria implements CriteriaInterface
{

    /**
     * @var array
     */
    private $columns;

    public function __construct(array $columns)
    {
        $this->columns = $columns;
    }

    /**
     * @inheritDoc
     */
    public function apply($model, RepositoryInterface $repository)
    {
        /** @var \Illuminate\Database\Eloquent\Builder $model */
        return $model->select($this->columns);
    }
}
