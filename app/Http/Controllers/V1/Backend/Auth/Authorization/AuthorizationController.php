<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1\Backend\Auth\Authorization;

use App\Http\Controllers\Controller;
use App\Models\Auth\User\User;
use App\Transformers\Auth\RoleTransformer;
use App\Transformers\Auth\UserTransformer;
use Domain\Auth\Actions\FindRoleByRouteKeyAction;
use Domain\User\Actions\FindUserByRouteKeyAction;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AuthorizationController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:'.config('setting.permission.permission_names.manage_authorization'));
    }

    /**
     *
     * @OA\Post(
     *     path="/auth/authorizations/assign-role-to-user",
     *     summary="Assign role to user",
     *     tags={"Authorization"},
     *     security={{"passport" : {}}},
     *     @OA\Parameter(
     *         name="include",
     *         in="query",
     *         required=false,
     *         @OA\Schema(
     *             type="array",
     *             @OA\Items(
     *                 type="string",
     *                 enum={"roles", "permissions"},
     *             )
     *         )
     *     ),
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     description="User key",
     *                     property="user_id",
     *                     type="int",
     *                 ),
     *                 @OA\Property(
     *                     description="Role key",
     *                     property="role_id",
     *                     type="int",
     *                 ),
     *                 example={
     *                     "user_id" : "user-at-usercom",
     *                     "role_id" : 1
     *                 }
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/UserTransformer")
     *         ),
     *     ),
     *     @OA\Response(
     *         response="401",
     *         description="Unauthorized",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Error")
     *         ),
     *     ),
     * )
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Spatie\Fractal\Fractal
     * @throws \Illuminate\Validation\ValidationException
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
        $attributes = $this->validate(
            $request,
            [
                'user_id' => $this->userRules(),
                'role_id' => $this->roleRules(),
            ]
        );

        $user = app(FindUserByRouteKeyAction::class)
            ->execute($attributes['user_id']);

        $user->assignRole($attributes['role_id']);

        return $this->fractal($user->refresh(), new UserTransformer());
    }

    /**
     * @OA\Delete(
     *     path="/auth/authorizations/revoke-role-from-user",
     *     summary="Revoke role from user",
     *     tags={"Authorization"},
     *     security={{"passport" : {}}},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     description="User key",
     *                     property="user_id",
     *                     type="int",
     *                 ),
     *                 @OA\Property(
     *                     description="Role keyd",
     *                     property="role_id",
     *                     type="int",
     *                 ),
     *                 example={
     *                     "user_id" : "user-at-usercom",
     *                     "role_id" : 1
     *                 }
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="The resource was revoked successfully.",
     *     ),
     *     @OA\Response(
     *         response="401",
     *         description="Unauthorized",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Error")
     *         ),
     *     ),
     * )
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response|\Laravel\Lumen\Http\ResponseFactory
     * @throws \Illuminate\Validation\ValidationException
     * @api                {delete} /auth/authorizations/revoke-role-from-user Revoke role form user
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
        $attributes = $this->validate(
            $request,
            [
                'user_id' => $this->userRules(),
                'role_id' => $this->roleRules(),
            ]
        );

        app(FindUserByRouteKeyAction::class)
            ->execute($attributes['user_id'])
            ->removeRole($attributes['role_id']);

        return response('', 204);
    }

    /**
     * @OA\Post(
     *     path="/auth/authorizations/assign-permission-to-user",
     *     summary="Assign permission to user",
     *     tags={"Authorization"},
     *     security={{"passport" : {}}},
     *     @OA\Parameter(
     *         name="include",
     *         in="query",
     *         required=false,
     *         @OA\Schema(
     *             type="array",
     *             @OA\Items(
     *                 type="string",
     *                 enum={"roles", "permissions"},
     *             )
     *         )
     *     ),
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     description="User key",
     *                     property="user_id",
     *                     type="int",
     *                 ),
     *                 @OA\Property(
     *                     description="Permission key",
     *                     property="permission_id",
     *                     type="int",
     *                 ),
     *                 example={
     *                     "user_id" : "user-at-usercom",
     *                     "permission_id" : 1
     *                 }
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/UserTransformer")
     *         ),
     *     ),
     *     @OA\Response(
     *         response="401",
     *         description="Unauthorized",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Error")
     *         ),
     *     ),
     * )
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Spatie\Fractal\Fractal
     * @throws \Illuminate\Validation\ValidationException
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
        $attributes = $this->validate(
            $request,
            [
                'user_id' => $this->userRules(),
                'permission_id' => $this->permissionRules(),
            ]
        );

        $user = app(FindUserByRouteKeyAction::class)
            ->execute($attributes['user_id']);

        $user->givePermissionTo($attributes['permission_id']);

        return $this->fractal($user->refresh(), new UserTransformer());
    }

    /**
     * @OA\Delete(
     *     path="/auth/authorizations/revoke-permission-from-user",
     *     summary="Revoke permission from user",
     *     tags={"Authorization"},
     *     security={{"passport" : {}}},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     description="User key",
     *                     property="user_id",
     *                     type="int",
     *                 ),
     *                 @OA\Property(
     *                     description="Permission key",
     *                     property="permission_id",
     *                     type="int",
     *                 ),
     *                 example={
     *                     "user_id" : "user-at-usercom",
     *                     "permission_id" : 1
     *                 }
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="The resource was revoked successfully.",
     *     ),
     *     @OA\Response(
     *         response="401",
     *         description="Unauthorized",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Error")
     *         ),
     *     ),
     * )
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response|\Laravel\Lumen\Http\ResponseFactory
     * @throws \Illuminate\Validation\ValidationException
     * @api                {delete} /auth/authorizations/revoke-permission-from-user Revoke permission from user
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
        $attributes = $this->validate(
            $request,
            [
                'user_id' => $this->userRules(),
                'permission_id' => $this->permissionRules(),
            ]
        );

        app(FindUserByRouteKeyAction::class)
            ->execute($attributes['user_id'])
            ->revokePermissionTo($attributes['permission_id']);

        return response('', 204);
    }

    /**
     * @OA\Post(
     *     path="/auth/authorizations/attach-permission-to-role",
     *     summary="Attach permission to role",
     *     tags={"Authorization"},
     *     security={{"passport" : {}}},
     *     @OA\Parameter(
     *         name="include",
     *         in="query",
     *         required=false,
     *         @OA\Schema(
     *             type="array",
     *             @OA\Items(
     *                 type="string",
     *                 enum={"roles", "permissions"},
     *             )
     *         )
     *     ),
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     description="Role key",
     *                     property="role_id",
     *                     type="int",
     *                 ),
     *                 @OA\Property(
     *                     description="Permission key",
     *                     property="permission_id",
     *                     type="int",
     *                 ),
     *                 example={
     *                     "role_id" : 1,
     *                     "permission_id" : 1
     *                 }
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/UserTransformer")
     *         ),
     *     ),
     *     @OA\Response(
     *         response="401",
     *         description="Unauthorized",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Error")
     *         ),
     *     ),
     * )
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Spatie\Fractal\Fractal
     * @throws \Illuminate\Validation\ValidationException
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
        $attributes = $this->validate(
            $request,
            [
                'role_id' => $this->roleRules(),
                'permission_id' => $this->permissionRules(),
            ]
        );

        $user = app(FindRoleByRouteKeyAction::class)
            ->execute($attributes['role_id']);

        $user->givePermissionTo($attributes['permission_id']);

        return $this->fractal($user->refresh(), new RoleTransformer());
    }

    /**
     * @OA\Delete(
     *     path="/auth/authorizations/revoke-permission-from-role",
     *     summary="Revoke permission from role",
     *     tags={"Authorization"},
     *     security={{"passport" : {}}},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     description="Role key",
     *                     property="role_id",
     *                     type="int",
     *                 ),
     *                 @OA\Property(
     *                     description="Permission key",
     *                     property="permission_id",
     *                     type="int",
     *                 ),
     *                 example={
     *                     "role_id" : 1,
     *                     "permission_id" : 1
     *                 }
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="The resource was revoked successfully.",
     *     ),
     *     @OA\Response(
     *         response="401",
     *         description="Unauthorized",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Error")
     *         ),
     *     ),
     * )
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response|\Laravel\Lumen\Http\ResponseFactory
     * @throws \Illuminate\Validation\ValidationException
     * @api                {delete} /auth/authorizations/revoke-permission-from-role Revoke permission from role
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
        $attributes = $this->validate(
            $request,
            [
                'role_id' => $this->roleRules(),
                'permission_id' => $this->permissionRules(),
            ]
        );

        app(FindRoleByRouteKeyAction::class)
            ->execute($attributes['role_id'])
            ->revokePermissionTo($attributes['permission_id']);

        return response('', 204);
    }

    private function roleRules(): array
    {
        return [
            'required',
            Rule::exists(config('permission.models.role'), app(config('permission.models.role'))->getRouteKeyName())
        ];
    }

    private function userRules(): array
    {
        return [
            'required', Rule::exists(User::class, (new User())->getRouteKeyName())
        ];
    }

    private function permissionRules(): array
    {
        return [
            'required',
            Rule::exists(config('permission.models.permission'), app(config('permission.models.permission'))->getRouteKeyName())
        ];
    }
}
