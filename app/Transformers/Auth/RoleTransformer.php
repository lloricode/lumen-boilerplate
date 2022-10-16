<?php

declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: Lloric Mayuga Garcia <lloricode@gmail.com>
 * Date: 11/24/18
 * Time: 3:31 PM
 */

namespace App\Transformers\Auth;

use App\Models\Auth\Role\Role;
use App\Transformers\BaseTransformer;

class RoleTransformer extends BaseTransformer
{
    protected array $defaultIncludes = [
        'permissions',
    ];

    /**
     * A Fractal transformer.
     *
     * @param  \App\Models\Auth\Role\Role  $role
     *
     * @return array
     */
    public function transform(Role $role)
    {
        return [
            'id' => self::forId($role),
            'name' => $role->name,
        ];
    }

    public function includePermissions(Role $role)
    {
        return $this->collection($role->permissions, new PermissionTransformer());
    }

    /** @return string */
    public function getResourceKey(): string
    {
        return 'roles';
    }
}
