<?php
/**
 * Created by PhpStorm.
 * User: Lloric Mayuga Garcia <lloricode@gmail.com>
 * Date: 12/16/18
 * Time: 11:25 AM
 */

namespace App\Http\Controllers\V1\Backend\Auth\Role;

use App\Http\Controllers\Controller;
use App\Repositories\Auth\Role\RoleRepository;
use App\Transformers\Auth\RoleTransformer;
use Dingo\Api\Http\Request;
use Prettus\Repository\Criteria\RequestCriteria;

/**
 * Class RoleController
 *
 * @package App\Http\Controllers\V1\Backend\Auth\Role
 */
class RoleController extends Controller
{
    protected $roleRepository;

    /**
     * RoleController constructor.
     *
     * @param \App\Repositories\Auth\Role\RoleRepository $roleRepository
     */
    public function __construct(RoleRepository $roleRepository)
    {
        $permissions = $roleRepository->resolveModel()::PERMISSIONS;

        $this->middleware('permission:' . $permissions['index'], ['only' => 'index']);
        $this->middleware('permission:' . $permissions['create'], ['only' => 'store']);
        $this->middleware('permission:' . $permissions['show'], ['only' => 'show']);
        $this->middleware('permission:' . $permissions['update'], ['only' => 'update']);
        $this->middleware('permission:' . $permissions['destroy'], ['only' => 'destroy']);

        $this->roleRepository = $roleRepository;
    }

    /**
     * @api                {get} /auth/roles Get all roles
     * @apiName            get-all-roles
     * @apiGroup           Role
     * @apiVersion         1.0.0
     * @apiPermission      Authenticated User
     * @apiUse             RolesResponse
     *
     * @param \Dingo\Api\Http\Request $request
     *
     * @return \Dingo\Api\Http\Response
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function index(Request $request)
    {
        $this->roleRepository->pushCriteria(new RequestCriteria($request));
        return $this->paginatorOrCollection($this->roleRepository->paginate(), new RoleTransformer);
    }

    /**
     * @api                {post} /auth/roles Store role
     * @apiName            store-role
     * @apiGroup           Role
     * @apiVersion         1.0.0
     * @apiPermission      Authenticated User
     * @apiUse             RoleCreatedResponse
     * @apiParam {String} name (required)
     *
     * @param \Dingo\Api\Http\Request $request
     *
     * @return \Dingo\Api\Http\Response
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(Request $request)
    {
        $role = $this->roleRepository->create([
            'name' => $request->input('name'),
        ]);
        return $this->item($role, new RoleTransformer)->statusCode(201);
    }

    /**
     * @api                {post} /auth/roles/{id} Show role
     * @apiName            show-role
     * @apiGroup           Role
     * @apiVersion         1.0.0
     * @apiPermission      Authenticated User
     * @apiUse             RoleResponse
     *
     * @param \Dingo\Api\Http\Request $request
     *
     * @return \Dingo\Api\Http\Response
     */
    public function show(Request $request)
    {
        $role = $this->roleRepository->find($this->decodeId($request));
        return $this->item($role, new RoleTransformer);
    }

    /**
     * @api                {put} /auth/roles Update role
     * @apiName            update-role
     * @apiGroup           Role
     * @apiVersion         1.0.0
     * @apiPermission      Authenticated User
     * @apiUse             RoleResponse
     * @apiParam {String} name
     *
     * @param \Dingo\Api\Http\Request $request
     *
     * @return \Dingo\Api\Http\Response
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(Request $request)
    {
        $role = $this->roleRepository->update([
            'name' => $request->input('name'),
        ], $this->decodeId($request));
        return $this->item($role, new RoleTransformer);
    }

    /**
     * @api                {delete} /auth/roles/{id} Destroy role
     * @apiName            destroy-role
     * @apiGroup           Role
     * @apiVersion         1.0.0
     * @apiPermission      Authenticated User
     * @apiUse             NoContentResponse
     *
     * @param \Dingo\Api\Http\Request $request
     *
     * @return \Dingo\Api\Http\Response
     */
    public function destroy(Request $request)
    {
        $this->roleRepository->delete($this->decodeId($request));
        return $this->response->noContent();
    }
}