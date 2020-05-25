<?php

namespace App\Criterion\Eloquent;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class ThisEqualThatCriteria
 *
 * @package App\Criterion\Eloquent
 * @author  Lloric Mayuga Garcia <lloricode@gmail.com>
 */
class ThisEqualThatCriteria implements CriteriaInterface
{
    private $column;
    /**
     * @var null
     */
    private $operator;
    /**
     * @var null
     */
    private $value;
    /**
     * @var string
     */
    private $boolean;
    /**
     * ThisEqualThatCriteria constructor.
     *
     * @param $column
     * @param  null  $operator
     * @param  null  $value
     * @param  string  $boolean
     */
//    public function __construct(string $field, $value = null, string $comparison = '=', bool $isOrWhere = false)
    public function __construct($column, $operator = null, $value = null, $boolean = 'and')
    {
        $this->column = $column;
        $this->operator = $operator;
        $this->value = $value;
        $this->boolean = $boolean;
    }

    /**
     * @param                                                   $model
     * @param  \Prettus\Repository\Contracts\RepositoryInterface  $repository
     *
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
        /** @var \Illuminate\Database\Eloquent\Builder $model */

        if (blank($this->value) && $this->boolean == 'and') {
            return $model->where($this->column, $this->operator);
        }

        return $model->where($this->column, $this->operator, $this->value, $this->boolean);
    }
}
