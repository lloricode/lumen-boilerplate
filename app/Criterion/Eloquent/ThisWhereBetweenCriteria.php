<?php

namespace App\Criterion\Eloquent;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class ThisWhereBetweenCriteria implements CriteriaInterface
{
    private $values;
    /**
     * @var string
     */
    private $column;
    /**
     * @var string
     */
    private $boolean;
    /**
     * @var bool
     */
    private $not;

    public function __construct($column, array $values, $boolean = 'and', $not = false)
    {
        $this->column = $column;
        $this->values = $values;
        $this->boolean = $boolean;
        $this->not = $not;
    }

    /**
     * @inheritDoc
     */
    public function apply($model, RepositoryInterface $repository)
    {
        /** @var \Illuminate\Database\Eloquent\Builder $model */
        return $model->whereBetween($this->column, $this->values, $this->boolean, $this->not);
    }
}
