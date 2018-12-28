<?php
/**
 * Created by PhpStorm.
 * User: Lloric Mayuga Garcia <lloricode@gmail.com>
 * Date: 12/16/18
 * Time: 11:25 AM
 */

namespace App\Http\Controllers\Backend\Auth\Role;

use App\Http\Controllers\Controller;
use App\Repositories\Auth\Role\RoleRepository;
use App\Transformers\Auth\RoleTransformer;
use Illuminate\Http\Request;
use Prettus\Repository\Criteria\RequestCriteria;

/**
 * Class RoleController
 *
 * @package App\Http\Controllers\Backend\Auth\Role
 * @group   Authorization
 */
class RoleController extends Controller
{
    protected $roleRepository;

    public function __construct(RoleRepository $roleRepository)
    {
        $permissions = app($roleRepository->model())::PERMISSIONS;

        $this->middleware('permission:' . $permissions['index'], ['only' => 'index']);
        $this->middleware('permission:' . $permissions['create'], ['only' => 'store']);
        $this->middleware('permission:' . $permissions['show'], ['only' => 'show']);
        $this->middleware('permission:' . $permissions['update'], ['only' => 'update']);
        $this->middleware('permission:' . $permissions['destroy'], ['only' => 'destroy']);

        $this->roleRepository = $roleRepository;
    }

    /**
     * Get all roles.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return mixed
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     * @authenticated
     * @responseFile responses/auth/roles.get.json
     */
    public function index(Request $request)
    {
        $this->roleRepository->pushCriteria(new RequestCriteria($request));
        return $this->response->paginator($this->roleRepository->model()::paginate(), new RoleTransformer,
            ['key' => 'roles']);
    }

    /**
     * Store role.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     * @authenticated
     * @bodyParam    name string required Role name. Example: test role name
     * @responseFile 201 responses/auth/role.get.json
     */
    public function store(Request $request)
    {
        $role = $this->roleRepository->create([
            'name' => $request->name,
        ]);
        return $this->response->item($role, new RoleTransformer, ['key' => 'roles'])->statusCode(201);
    }

    /**
     * Show role.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return mixed
     * @authenticated
     * @responseFile responses/auth/role.get.json
     */
    public function show(Request $request)
    {
        $role = $this->roleRepository->find($this->decodeId($request));
        return $this->response->item($role, new RoleTransformer, ['key' => 'roles']);
    }

    /**
     * Update role.
     *
     * <br />This can be done on none default roles.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return mixed
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     * @authenticated
     * @bodyParam    name string required Role name. Example: test role name
     * @responseFile responses/auth/role.get.json
     */
    public function update(Request $request)
    {

        $role = $this->roleRepository->update([
            'name' => $request->input('name'),
        ], $this->decodeId($request));
        return $this->response->item($role, new RoleTransformer, ['key' => 'roles']);
    }

    /**
     * Destroy role.
     *
     * <br />This can be done on none default roles.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     * @authenticated
     * @responseFile 204 responses/no-content.get.json
     */
    public function destroy(Request $request)
    {
        $this->roleRepository->delete($this->decodeId($request));
        return $this->response->noContent();
    }
}