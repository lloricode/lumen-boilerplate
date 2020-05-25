<?php

namespace App\Criterion\Eloquent;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class ThisOrderByCriteria implements CriteriaInterface
{
    private $column;
    private $order;

    /**
     * ThisOrderByCriteria constructor.
     *
     * @param  string  $column
     * @param  string  $order
     */
    public function __construct(string $column, string $order = 'asc')
    {
        $this->column = $column;
        $this->order = $order;
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
        /** @var \Illuminate\Database\Eloquent\Builder $model */
        return $model->orderBy($this->column, $this->order);
    }
}
