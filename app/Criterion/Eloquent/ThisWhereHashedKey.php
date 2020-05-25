<?php

namespace App\Criterion\Eloquent;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class ThisWhereHashedKey implements CriteriaInterface
{

    /**
     * @var string
     */
    private $hashed;
    /**
     * @var string
     */
    private $column;

    public function __construct(string $hashed, string $column = 'id')
    {
        $this->hashed = $hashed;
        $this->column = $column;
    }

    /**
     * @inheritDoc
     */
    public function apply($model, RepositoryInterface $repository)
    {
        /** @var $model \HalcyonLaravelBoilerplate\CoreBase\Traits\Hashable */
        return $model->whereHashedKey($this->column, $this->hashed);
    }
}
