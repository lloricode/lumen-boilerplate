<?php
/**
 * Created by PhpStorm.
 * User: Lloric Mayuga Garcia <lloricode@gmail.com>
 * Date: 12/23/18
 * Time: 5:54 PM
 */

namespace App\Repositories\Auth\Permission;

use App\Repositories\BaseRepository;

/**
 * Class PermissionRepositoryEloquent
 *
 * @package App\Repositories\Auth\Permission
 */
class PermissionRepositoryEloquent extends BaseRepository implements PermissionRepository
{
    protected $fieldSearchable = [
        'name' => 'like',
    ];

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return config('permission.models.permission');
    }
}