<?php
/**
 * Created by PhpStorm.
 * User: Lloric Mayuga Garcia <lloricode@gmail.com>
 * Date: 12/1/18
 * Time: 11:37 AM
 */

namespace App\Criterion\Eloquent;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class ThisWhereEqualsCriteria implements CriteriaInterface
{
    protected $column;

    protected $value;

    public function __construct(string $column, string $value)
    {
        $this->column = $column;
        $this->value = $value;
    }

    /**
     * Apply criteria in query repository
     *
     * @param                     $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
        return $model->where($this->column, $this->value);
    }
}