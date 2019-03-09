<?php
/**
 * Created by PhpStorm.
 * User: Lloric Mayuga Garcia <lloricode@gmail.com>
 * Date: 3/7/19
 * Time: 6:48 PM
 */

namespace App\Repositories\Auth\Role;

use App\Repositories\BaseRepositoryInterface;

/**
 * Interface RoleRepository
 *
 * @package App\Repositories\Auth\Role
 */
interface RoleRepository extends BaseRepositoryInterface
{
    /**
     * @param array $attributes
     * @param       $id
     *
     * @return mixed
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(array $attributes, $id);

    /**
     * @param     $id
     * @param int $permissionId
     */
    public function givePermissionTo($id, int $permissionId);

    /**
     * @param     $id
     * @param int $permissionId
     */
    public function revokePermissionTo($id, int $permissionId);
}