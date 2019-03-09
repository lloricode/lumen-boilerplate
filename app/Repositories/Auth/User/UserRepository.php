<?php
/**
 * Created by PhpStorm.
 * User: Lloric Mayuga Garcia <lloricode@gmail.com>
 * Date: 3/7/19
 * Time: 6:49 PM
 */

namespace App\Repositories\Auth\User;

use App\Repositories\BaseRepositoryInterface;

interface UserRepository extends BaseRepositoryInterface
{
    /**
     * @param     $id
     * @param int $roleId
     *
     * @return mixed
     */
    public function assignRole($id, int $roleId);

    /**
     * @param     $id
     * @param int $permissionId
     */
    public function givePermissionTo($id, int $permissionId);

    /**
     * @param     $id
     * @param int $roleId
     */
    public function removeRole($id, int $roleId);

    /**
     * @param     $id
     * @param int $permissionId
     */
    public function revokePermissionTo($id, int $permissionId);
}