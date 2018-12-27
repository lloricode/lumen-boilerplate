<?php
/**
 * Created by PhpStorm.
 * User: Lloric Mayuga Garcia <lloricode@gmail.com>
 * Date: 12/26/18
 * Time: 4:43 PM
 */

namespace App\Http\Controllers\Backend\Auth\Authorization;

use App\Http\Controllers\Controller;
use App\Presenters\Auth\RolePresenter;
use App\Presenters\Auth\UserPresenter;
use App\Repositories\Auth\Role\RoleRepository;
use App\Repositories\Auth\User\UserRepository;
use Illuminate\Http\Request;

/**
 * Class AuthorizationController
 *
 * @package App\Http\Controllers\Backend\Auth\Authorization
 * @group   Authorization Management
 */
class AuthorizationController extends Controller
{
    protected $userRepository;
    protected $roleRepository;

    public function __construct(UserRepository $userRepository, RoleRepository $roleRepository)
    {
        $this->userRepository = $userRepository;
        $this->roleRepository = $roleRepository;
    }

    /**
     * Assign role to user.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return mixed
     * @throws \Exception
     * @authenticated
     * @bodyParam    role_id string required Role hashed id. Example: Xyo35kNbmqvjJP9zn9aKeGL6Wz1MBwlA
     * @bodyParam    user_id string required User hashed id. Example: Xyo35kNbmqvjJP9zn9aKeGL6Wz1MBwlA
     * @responseFile responses/auth/user.get.json
     */
    public function assignRoleToUser(Request $request)
    {
        $userId = $this->decodeHash($request->user_id);

        $this->userRepository->assignRole($userId, $this->decodeHash($request->role_id));

        $this->userRepository->setPresenter(UserPresenter::class);
        return $this->userRepository->find($userId);
    }

    /**
     * Revoke role form user.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return mixed
     * @throws \Exception
     * @authenticated
     * @bodyParam    role_id string required Role hashed id. Example: Xyo35kNbmqvjJP9zn9aKeGL6Wz1MBwlA
     * @bodyParam    user_id string required User hashed id. Example: Xyo35kNbmqvjJP9zn9aKeGL6Wz1MBwlA
     * @responseFile responses/auth/user.get.json
     */
    public function revokeRoleFormUser(Request $request)
    {
        $userId = $this->decodeHash($request->user_id);

        $this->userRepository->removeRole($userId, $this->decodeHash($request->role_id));

        $this->userRepository->setPresenter(UserPresenter::class);
        return $this->userRepository->find($userId);

    }

    /**
     * Assign permission to user.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return mixed
     * @throws \Exception
     * @authenticated
     * @bodyParam    permission_id string required Permission hashed id. Example: Xyo35kNbmqvjJP9zn9aKeGL6Wz1MBwlA
     * @bodyParam    user_id string required User hashed id. Example: Xyo35kNbmqvjJP9zn9aKeGL6Wz1MBwlA
     * @responseFile responses/auth/user.get.json
     */
    public function assignPermissionToUser(Request $request)
    {
        $userId = $this->decodeHash($request->user_id);

        $this->userRepository->givePermissionTo($userId, $this->decodeHash($request->permission_id));

        $this->userRepository->setPresenter(UserPresenter::class);
        return $this->userRepository->find($userId);

    }

    /**
     * Revoke permission from user.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return mixed
     * @throws \Exception
     * @authenticated
     * @bodyParam    permission_id string required Permission hashed id. Example: Xyo35kNbmqvjJP9zn9aKeGL6Wz1MBwlA
     * @bodyParam    user_id string required User hashed id. Example: Xyo35kNbmqvjJP9zn9aKeGL6Wz1MBwlA
     * @responseFile responses/auth/user.get.json
     */
    public function revokePermissionFromUser(Request $request)
    {
        $userId = $this->decodeHash($request->user_id);

        $this->userRepository->revokePermissionTo($userId, $this->decodeHash($request->permission_id));

        $this->userRepository->setPresenter(UserPresenter::class);
        return $this->userRepository->find($userId);

    }

    /**
     * Attach permission to role.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return mixed
     * @throws \Exception
     * @authenticated
     * @bodyParam    permission_id string required Permission hashed id. Example: Xyo35kNbmqvjJP9zn9aKeGL6Wz1MBwlA
     * @bodyParam    role_id string required Role hashed id. Example: Xyo35kNbmqvjJP9zn9aKeGL6Wz1MBwlA
     * @responseFile responses/auth/role.get.json
     */
    public function attachPermissionToRole(Request $request)
    {
        $roleId = $this->decodeHash($request->role_id);

        $this->roleRepository->givePermissionTo($roleId, $this->decodeHash($request->permission_id));

        $this->roleRepository->setPresenter(RolePresenter::class);
        return $this->roleRepository->find($roleId);
    }

    /**
     * Revoke permission from role.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return mixed
     * @throws \Exception
     * @authenticated
     * @bodyParam    permission_id string required Permission hashed id. Example: Xyo35kNbmqvjJP9zn9aKeGL6Wz1MBwlA
     * @bodyParam    role_id string required Role hashed id. Example: Xyo35kNbmqvjJP9zn9aKeGL6Wz1MBwlA
     * @responseFile responses/auth/role.get.json
     */
    public function revokePermissionFromRole(Request $request)
    {
        $roleId = $this->decodeHash($request->role_id);

        $this->roleRepository->revokePermissionTo($roleId, $this->decodeHash($request->permission_id));

        $this->roleRepository->setPresenter(RolePresenter::class);
        return $this->roleRepository->find($roleId);
    }
}