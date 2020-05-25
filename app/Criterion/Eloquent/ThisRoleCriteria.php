<?php

namespace App\Criterion\Eloquent;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class ThisRoleCriteria implements CriteriaInterface
{

    private $roles;
    /**
     * @var null
     */
    private $guard;

    public function __construct($roles, $guard = null)
    {
        $this->roles = $roles;
        $this->guard = $guard;
    }

    /**
     * @inheritDoc
     */
    public function apply($model, RepositoryInterface $repository)
    {
        /** @var $model \Spatie\Permission\Traits\HasRoles */
        return $model->role($this->roles, $this->guard);
    }
}
