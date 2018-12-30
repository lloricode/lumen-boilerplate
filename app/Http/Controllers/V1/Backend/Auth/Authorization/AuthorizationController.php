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
use Dingo\Api\Http\Request;

/**
 * Authorization resource representation.
 *
 * @Resource("Authorization Management", uri="/auth/authorizations")
 */
class AuthorizationController extends Controller
{
    protected $userRepository;
    protected $roleRepository;

    /**
     * AuthorizationController constructor.
     *
     * @param \App\Repositories\Auth\User\UserRepository $userRepository
     * @param \App\Repositories\Auth\Role\RoleRepository $roleRepository
     */
    public function __construct(UserRepository $userRepository, RoleRepository $roleRepository)
    {
        $this->userRepository = $userRepository;
        $this->roleRepository = $roleRepository;
    }

    /**
     * Assign role to user.
     *
     * @param \Dingo\Api\Http\Request $request
     *
     * @return \Dingo\Api\Http\Response
     * @Post("/assign-role-to-user")
     * @Versions({"v1"})
     * @Request({
     *     "role_id": "Xyo35kNbmqvjJP9zn9aKeGL6Wz1MBwlA",
     *     "user_id": "EK5BqP62N14zargZP97exZAMYpmQ0jGw"
     * }, headers={"Content-Type": "application/x-www-form-urlencoded"})
     * @Response(200, body={"data":{"type":"users","id":"BX0gNpxGL2ymj8zgD9lqnrVZwQaMDkOY","attributes":
     *     {"first_name":"System","last_name":"Root","email":"system@system.com",
     *     "created_at":"29/12/201810:46:30AM","created_at_readable":"1hourago",
     *     "created_at_tz":"29/12/201802:46:30AM","created_at_readable_tz":"1hourago",
     *     "updated_at":"29/12/201810:46:30AM","updated_at_readable":"1hourago",
     *     "updated_at_tz":"29/12/201802:46:30AM","updated_at_readable_tz":"1hourago"}}})
     * @Parameters({
     *      @Parameter("include", type="string", required=false, description="Include relationship", default=null)
     * })
     */
    public function assignRoleToUser(Request $request)
    {
        $userId = $this->decodeHash($request->input('user_id'));

        $this->userRepository->assignRole($userId, $this->decodeHash($request->input('role_id')));

        return $this->response->item($this->userRepository->find($userId), new UserTransformer, ['key' => 'users']);
    }

    /**
     * Revoke role form user.
     *
     * @param \Dingo\Api\Http\Request $request
     *
     * @return \Dingo\Api\Http\Response
     * @Post("/revoke-role-from-user")
     * @Versions({"v1"})
     * @Request({
     *     "role_id": "Xyo35kNbmqvjJP9zn9aKeGL6Wz1MBwlA",
     *     "user_id": "EK5BqP62N14zargZP97exZAMYpmQ0jGw"
     * }, headers={"Content-Type": "application/x-www-form-urlencoded"})
     * @Response(200, body={"data":{"type":"users","id":"BX0gNpxGL2ymj8zgD9lqnrVZwQaMDkOY","attributes":
     *     {"first_name":"System","last_name":"Root","email":"system@system.com",
     *     "created_at":"29/12/201810:46:30AM","created_at_readable":"1hourago",
     *     "created_at_tz":"29/12/201802:46:30AM","created_at_readable_tz":"1hourago",
     *     "updated_at":"29/12/201810:46:30AM","updated_at_readable":"1hourago",
     *     "updated_at_tz":"29/12/201802:46:30AM","updated_at_readable_tz":"1hourago"}}})
     * @Parameters({
     *      @Parameter("include", type="string", required=false, description="Include relationship", default=null)
     * })
     */
    public function revokeRoleFormUser(Request $request)
    {
        $userId = $this->decodeHash($request->input('user_id'));

        $this->userRepository->removeRole($userId, $this->decodeHash($request->input('role_id')));

        $user = $this->userRepository->find($userId);
        return $this->response->item($user, new UserTransformer, ['key' => 'users']);
    }

    /**
     * Assign permission to user.
     *
     * @param \Dingo\Api\Http\Request $request
     *
     * @return \Dingo\Api\Http\Response
     * @Post("/assign-permission-to-user")
     * @Versions({"v1"})
     * @Request({
     *     "role_id": "Xyo35kNbmqvjJP9zn9aKeGL6Wz1MBwlA",
     *     "permission_id": "EK5BqP62N14zargZP97exZAMYpmQ0jGw"
     * }, headers={"Content-Type": "application/x-www-form-urlencoded"})
     * @Response(200, body={"data":{"type":"users","id":"BX0gNpxGL2ymj8zgD9lqnrVZwQaMDkOY","attributes":
     *     {"first_name":"System","last_name":"Root","email":"system@system.com",
     *     "created_at":"29/12/201810:46:30AM","created_at_readable":"1hourago",
     *     "created_at_tz":"29/12/201802:46:30AM","created_at_readable_tz":"1hourago",
     *     "updated_at":"29/12/201810:46:30AM","updated_at_readable":"1hourago",
     *     "updated_at_tz":"29/12/201802:46:30AM","updated_at_readable_tz":"1hourago"}}})
     * @Parameters({
     *      @Parameter("include", type="string", required=false, description="Include relationship", default=null)
     * })
     */
    public function assignPermissionToUser(Request $request)
    {
        $userId = $this->decodeHash($request->input('user_id'));

        $this->userRepository->givePermissionTo($userId, $this->decodeHash($request->input('permission_id')));

        return $this->response->item($this->userRepository->find($userId), new UserTransformer, ['key' => 'users']);
    }

    /**
     * Revoke permission from user.
     *
     * @param \Dingo\Api\Http\Request $request
     *
     * @return \Dingo\Api\Http\Response
     * @Post("/revoke-permission-from-user")
     * @Versions({"v1"})
     * @Request({
     *     "role_id": "Xyo35kNbmqvjJP9zn9aKeGL6Wz1MBwlA",
     *     "permission_id": "EK5BqP62N14zargZP97exZAMYpmQ0jGw"
     * }, headers={"Content-Type": "application/x-www-form-urlencoded"})
     * @Response(200, body={"data":{"type":"users","id":"BX0gNpxGL2ymj8zgD9lqnrVZwQaMDkOY","attributes":
     *     {"first_name":"System","last_name":"Root","email":"system@system.com",
     *     "created_at":"29/12/201810:46:30AM","created_at_readable":"1hourago",
     *     "created_at_tz":"29/12/201802:46:30AM","created_at_readable_tz":"1hourago",
     *     "updated_at":"29/12/201810:46:30AM","updated_at_readable":"1hourago",
     *     "updated_at_tz":"29/12/201802:46:30AM","updated_at_readable_tz":"1hourago"}}})
     * @Parameters({
     *      @Parameter("include", type="string", required=false, description="Include relationship", default=null)
     * })
     */
    public function revokePermissionFromUser(Request $request)
    {
        $userId = $this->decodeHash($request->input('user_id'));

        $this->userRepository->revokePermissionTo($userId, $this->decodeHash($request->input('permission_id')));

        return $this->response->item($this->userRepository->find($userId), new UserTransformer, ['key' => 'users']);

    }

    /**
     * Attach permission to role.
     *
     * @param \Dingo\Api\Http\Request $request
     *
     * @return \Dingo\Api\Http\Response
     * @Post("/attach-permission-to-role")
     * @Versions({"v1"})
     * @Request({
     *     "role_id": "Xyo35kNbmqvjJP9zn9aKeGL6Wz1MBwlA",
     *     "permission_id": "EK5BqP62N14zargZP97exZAMYpmQ0jGw"
     * }, headers={"Content-Type": "application/x-www-form-urlencoded"})
     * @Response(200, body={"data":{"type":"roles","id":"X0NDx2YlwZ8mep6og6AM3OqoP1nrkWJa",
     *     "attributes":{"name":"executive"},"relationships":{"permissions":{"data":{}}}}})
     * @Parameters({
     *      @Parameter("include", type="string", required=false, description="Include relationship", default=null)
     * })
     */
    public function attachPermissionToRole(Request $request)
    {
        $roleId = $this->decodeHash($request->input('role_id'));

        $this->roleRepository->givePermissionTo($roleId, $this->decodeHash($request->input('permission_id')));

        return $this->response->item($this->roleRepository->find($roleId), new RoleTransformer, ['key' => 'roles']);
    }

    /**
     * Revoke permission from role.
     *
     * /**
     * @param \Dingo\Api\Http\Request $request
     *
     * @return \Dingo\Api\Http\Response
     * @Post("/revoke-permission-from-role")
     * @Versions({"v1"})
     * @Request({
     *     "role_id": "Xyo35kNbmqvjJP9zn9aKeGL6Wz1MBwlA",
     *     "permission_id": "EK5BqP62N14zargZP97exZAMYpmQ0jGw"
     * }, headers={"Content-Type": "application/x-www-form-urlencoded"})
     * @Response(200, body={"data":{"type":"roles","id":"X0NDx2YlwZ8mep6og6AM3OqoP1nrkWJa",
     *     "attributes":{"name":"executive"},"relationships":{"permissions":{"data":{}}}}})
     * @Parameters({
     *      @Parameter("include", type="string", required=false, description="Include relationship", default=null)
     * })
     */
    public function revokePermissionFromRole(Request $request)
    {
        $roleId = $this->decodeHash($request->input('role_id'));

        $this->roleRepository->revokePermissionTo($roleId, $this->decodeHash($request->input('permission_id')));

        return $this->response->item($this->roleRepository->find($roleId), new RoleTransformer, ['key' => 'roles']);
    }
}