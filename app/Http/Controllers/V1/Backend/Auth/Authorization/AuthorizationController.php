<?php
/**
 * Created by PhpStorm.
 * User: Lloric Mayuga Garcia <lloricode@gmail.com>
 * Date: 12/26/18
 * Time: 4:43 PM
 */

namespace App\Http\Controllers\V1\Backend\Auth\Authorization;

use App\Http\Controllers\Controller;
use App\Repositories\Auth\Role\RoleRepository;
use App\Repositories\Auth\User\UserRepository;
use App\Transformers\Auth\RoleTransformer;
use App\Transformers\Auth\UserTransformer;
use Illuminate\Http\Request;

/**
 * Class AuthorizationController
 *
 * @package App\Http\Controllers\V1\Backend\Auth\Authorization
 */
class AuthorizationController extends Controller
{
    protected $userRepository;
    protected $roleRepository;

    /**
     * AuthorizationController constructor.
     *
     * @param  \App\Repositories\Auth\User\UserRepository  $userRepository
     * @param  \App\Repositories\Auth\Role\RoleRepository  $roleRepository
     */
    public function __construct(UserRepository $userRepository, RoleRepository $roleRepository)
    {
        $this->middleware('permission:'.config('setting.permission.permission_names.manage_authorization'));

        $this->userRepository = $userRepository;
        $this->roleRepository = $roleRepository;
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Spatie\Fractal\Fractal
     * @api                {post} /auth/authorizations/assign-role-to-user Assign role to user
     * @apiName            assign-role-to-user
     * @apiGroup           Authorization
     * @apiVersion         1.0.0
     * @apiPermission      Authenticated User
     * @apiUse             UserResponse
     * @apiParam {String} user_id User hashed id
     * @apiParam {String} role_id Role hashed id
     *
     */
    public function assignRoleToUser(Request $request)
    {
        $userId = $this->decodeHash($request->input('user_id'));

        $this->userRepository->assignRole($userId, $this->decodeHash($request->input('role_id')));

        return $this->fractal($this->userRepository->find($userId), new UserTransformer());
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Spatie\Fractal\Fractal
     * @api                {post} /auth/authorizations/revoke-role-from-user Revoke role form user
     * @apiName            revoke-role-from-user
     * @apiGroup           Authorization
     * @apiVersion         1.0.0
     * @apiPermission      Authenticated User
     * @apiUse             UserResponse
     * @apiParam {String} user_id User hashed id
     * @apiParam {String} role_id Role hashed id
     *
     */
    public function revokeRoleFormUser(Request $request)
    {
        $userId = $this->decodeHash($request->input('user_id'));

        $this->userRepository->removeRole($userId, $this->decodeHash($request->input('role_id')));

        $user = $this->userRepository->find($userId);
        return $this->fractal($user, new UserTransformer());
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Spatie\Fractal\Fractal
     * @api                {post} /auth/authorizations/assign-permission-to-user Assign permission to user
     * @apiName            assign-permission-to-user
     * @apiGroup           Authorization
     * @apiVersion         1.0.0
     * @apiPermission      Authenticated User
     * @apiUse             UserResponse
     * @apiParam {String} user_id User hashed id
     * @apiParam {String} permission_id Permission hashed id
     *
     */
    public function assignPermissionToUser(Request $request)
    {
        $userId = $this->decodeHash($request->input('user_id'));

        $this->userRepository->givePermissionTo($userId, $this->decodeHash($request->input('permission_id')));

        return $this->fractal($this->userRepository->find($userId), new UserTransformer());
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Spatie\Fractal\Fractal
     * @api                {post} /auth/authorizations/revoke-permission-from-user Revoke permission from user
     * @apiName            revoke-permission-from-user
     * @apiGroup           Authorization
     * @apiVersion         1.0.0
     * @apiPermission      Authenticated User
     * @apiUse             UserResponse
     * @apiParam {String} user_id User hashed id
     * @apiParam {String} permission_id Permission hashed id
     *
     */
    public function revokePermissionFromUser(Request $request)
    {
        $userId = $this->decodeHash($request->input('user_id'));

        $this->userRepository->revokePermissionTo($userId, $this->decodeHash($request->input('permission_id')));

        return $this->fractal($this->userRepository->find($userId), new UserTransformer());
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Spatie\Fractal\Fractal
     * @api                {post} /auth/authorizations/attach-permission-to-role Attach permission to role
     * @apiName            attach-permission-to-role
     * @apiGroup           Authorization
     * @apiVersion         1.0.0
     * @apiPermission      Authenticated User
     * @apiUse             RoleResponse
     * @apiParam {String} role_id Role hashed id
     * @apiParam {String} permission_id Permission hashed id
     *
     */
    public function attachPermissionToRole(Request $request)
    {
        $roleId = $this->decodeHash($request->input('role_id'));

        $this->roleRepository->givePermissionTo($roleId, $this->decodeHash($request->input('permission_id')));

        return $this->fractal($this->roleRepository->find($roleId), new RoleTransformer());
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Spatie\Fractal\Fractal
     * @api                {post} /auth/authorizations/revoke-permission-from-role Revoke permission from role
     * @apiName            revoke-permission-from-role
     * @apiGroup           Authorization
     * @apiVersion         1.0.0
     * @apiPermission      Authenticated User
     * @apiUse             RoleResponse
     * @apiParam {String} role_id Role hashed id
     * @apiParam {String} permission_id Permission hashed id
     *
     */
    public function revokePermissionFromRole(Request $request)
    {
        $roleId = $this->decodeHash($request->input('role_id'));

        $this->roleRepository->revokePermissionTo($roleId, $this->decodeHash($request->input('permission_id')));

        return $this->fractal($this->roleRepository->find($roleId), new RoleTransformer());
    }
}