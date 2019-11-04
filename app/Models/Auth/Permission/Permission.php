<?php
/**
 * Created by PhpStorm.
 * User: Lloric Mayuga Garcia <lloricode@gmail.com>
 * Date: 12/16/18
 * Time: 11:08 AM
 */

namespace App\Models\Auth\Permission;

use App\Traits\Hashable;
use Illuminate\Database\Eloquent\Builder;

/**
 * App\Models\Auth\Permission\Permission
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Auth\Permission\Permission[] $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Auth\Role\Role[] $roles
 * @property-read int|null $roles_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Auth\User\User[] $users
 * @property-read int|null $users_count
 * @method static Builder|Permission newModelQuery()
 * @method static Builder|Permission newQuery()
 * @method static Builder|\Spatie\Permission\Models\Permission permission($permissions)
 * @method static Builder|Permission query()
 * @method static Builder|\Spatie\Permission\Models\Permission role($roles, $guard = null)
 * @mixin \Eloquent
 */
class Permission extends \Spatie\Permission\Models\Permission
{
    use Hashable;

    /**
     * all permissions
     *
     * name => value
     */
    const PERMISSIONS = [
        'index' => 'permission index',
        'show' => 'permission show',
    ];
}