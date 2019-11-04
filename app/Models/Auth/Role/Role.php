<?php
/**
 * Created by PhpStorm.
 * User: Lloric Mayuga Garcia <lloricode@gmail.com>
 * Date: 12/9/18
 * Time: 8:04 PM
 */

namespace App\Models\Auth\Role;

use App\Traits\Hashable;
use Illuminate\Database\Eloquent\Builder;

/**
 * App\Models\Auth\Role\Role
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Auth\Permission\Permission[] $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Auth\User\User[] $users
 * @property-read int|null $users_count
 * @method static Builder|Role newModelQuery()
 * @method static Builder|Role newQuery()
 * @method static Builder|\Spatie\Permission\Models\Role permission($permissions)
 * @method static Builder|Role query()
 * @mixin \Eloquent
 */
class Role extends \Spatie\Permission\Models\Role
{
    use Hashable;

    /**
     * all permissions
     *
     * name => value
     */
    const PERMISSIONS = [
        'index' => 'role index',
        'create' => 'role store',
        'show' => 'role show',
        'update' => 'role update',
        'destroy' => 'role destroy',
    ];
}