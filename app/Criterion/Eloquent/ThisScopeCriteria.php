<?php

namespace App\Criterion\Eloquent;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class ThisScopeCriteria implements CriteriaInterface
{
    /**
     * @var string
     */
    private $scopeName;

    public function __construct(string $scopeName)
    {
        $this->scopeName = $scopeName;
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
        return $model->{$this->scopeName}();
    }
}
