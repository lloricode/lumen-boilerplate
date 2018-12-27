<?php
/**
 * Created by PhpStorm.
 * User: Lloric Mayuga Garcia <lloricode@gmail.com>
 * Date: 12/16/18
 * Time: 11:08 AM
 */

namespace App\Models\Auth\Permission;

use App\Traits\Hashable;

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