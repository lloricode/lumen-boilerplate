<?php

namespace App\Criterion\Eloquent;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class ThisWhereDateCriteria implements CriteriaInterface
{
    private $value;
    /**
     * @var string
     */
    private $column;
    /**
     * @var string
     */
    private $operator;
    /**
     * @var string
     */
    private $boolean;

    public function __construct($column, $operator, $value = null, $boolean = 'and')
    {
        $this->column = $column;
        $this->operator = $operator;
        $this->value = $value;
        $this->boolean = $boolean;
    }

    /**
     * @inheritDoc
     */
    public function apply($model, RepositoryInterface $repository)
    {
        /** @var \Illuminate\Database\Eloquent\Builder $model */

        if (blank($this->value) && $this->boolean == 'and') {
            return $model->whereDate($this->column, $this->operator);
        }

        return $model->whereDate($this->column, $this->operator, $this->value, $this->boolean);
    }
}
