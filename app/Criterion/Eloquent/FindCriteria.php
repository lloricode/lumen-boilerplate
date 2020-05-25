<?php

namespace App\Criterion\Eloquent;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class FindCriteria implements CriteriaInterface
{
    /** @var string */
    private $value;

    public function __construct(string $value)
    {
        $this->value = $value;
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
        return (new ThisEqualThatCriteria($repository->makeModel()->getRouteKeyName(), $this->value))
            ->apply($model, $repository);
    }
}