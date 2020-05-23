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
use Illuminate\Http\Request;
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
     * @param  \App\Repositories\Auth\Role\RoleRepository  $roleRepository
     */
    public function __construct(RoleRepository $roleRepository)
    {
        $permissions = $roleRepository->makeModel()::PERMISSIONS;

        $this->middleware('permission:'.$permissions['index'], ['only' => 'index']);
        $this->middleware('permission:'.$permissions['create'], ['only' => 'store']);
        $this->middleware('permission:'.$permissions['show'], ['only' => 'show']);
        $this->middleware('permission:'.$permissions['update'], ['only' => 'update']);
        $this->middleware('permission:'.$permissions['destroy'], ['only' => 'destroy']);

        $this->roleRepository = $roleRepository;
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Spatie\Fractal\Fractal
     * @api                {get} /auth/roles Get all roles
     * @apiName            get-all-roles
     * @apiGroup           Role
     * @apiVersion         1.0.0
     * @apiPermission      Authenticated User
     * @apiUse             RolesResponse
     *
     */
    public function index(Request $request)
    {
        $this->roleRepository->pushCriteria(new RequestCriteria($request));
        return $this->fractal($this->roleRepository->paginate(), new RoleTransformer());
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     * @api                {post} /auth/roles Store role
     * @apiName            store-role
     * @apiGroup           Role
     * @apiVersion         1.0.0
     * @apiPermission      Authenticated User
     * @apiUse             RoleCreatedResponse
     * @apiParam {String} name (required)
     *
     */
    public function store(Request $request)
    {
        $attributes = $this->validate(
            $request,
            [
                'name' => 'required|string',
            ]
        );

        $role = $this->roleRepository->create(
            [
                'name' => $attributes['name'],
            ]
        );

        return $this->fractal($role, new RoleTransformer())->respond(201);
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $id
     *
     * @return \Spatie\Fractal\Fractal
     * @api                {post} /auth/roles/{id} Show role
     * @apiName            show-role
     * @apiGroup           Role
     * @apiVersion         1.0.0
     * @apiPermission      Authenticated User
     * @apiUse             RoleResponse
     *
     */
    public function show(Request $request, string $id)
    {
        $this->roleRepository->pushCriteria(new RequestCriteria($request));
        $role = $this->roleRepository->find($this->decodeHash($id));
        return $this->fractal($role, new RoleTransformer());
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $id
     *
     * @return \Spatie\Fractal\Fractal
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     * @throws \Illuminate\Validation\ValidationException
     * @api                {put} /auth/roles Update role
     * @apiName            update-role
     * @apiGroup           Role
     * @apiVersion         1.0.0
     * @apiPermission      Authenticated User
     * @apiUse             RoleResponse
     * @apiParam {String} name
     *
     */
    public function update(Request $request, string $id)
    {
        $attributes = $this->validate(
            $request,
            [
                'name' => 'required|string',
            ]
        );

        $role = $this->roleRepository->update(
            [
                'name' => $attributes['name'],
            ],
            $this->decodeHash($id)
        );
        return $this->fractal($role, new RoleTransformer());
    }

    /**
     * @param  string  $id
     *
     * @return \Illuminate\Http\Response|\Laravel\Lumen\Http\ResponseFactory
     * @api                {delete} /auth/roles/{id} Destroy role
     * @apiName            destroy-role
     * @apiGroup           Role
     * @apiVersion         1.0.0
     * @apiPermission      Authenticated User
     * @apiUse             NoContentResponse
     *
     */
    public function destroy(string $id)
    {
        $this->roleRepository->delete($this->decodeHash($id));
        return response('', 204);
    }
}