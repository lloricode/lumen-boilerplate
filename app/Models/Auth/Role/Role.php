<?php
/**
 * Created by PhpStorm.
 * User: Lloric Mayuga Garcia <lloricode@gmail.com>
 * Date: 12/9/18
 * Time: 8:04 PM
 */

namespace App\Models\Auth\Role;

use App\Traits\Hashable;

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