<?php
/**
 * Created by PhpStorm.
 * User: Lloric Mayuga Garcia <lloricode@gmail.com>
 * Date: 12/16/18
 * Time: 11:25 AM
 */

namespace App\Http\Controllers\V1\Backend\Auth\Permission;

use App\Http\Controllers\Controller;
use App\Repositories\Auth\Permission\PermissionRepository;
use App\Transformers\Auth\PermissionTransformer;
use Dingo\Api\Http\Request;
use Prettus\Repository\Criteria\RequestCriteria;

/**
 * Class PermissionController
 *
 * @package App\Http\Controllers\V1\Backend\Auth\Permission
 */
class PermissionController extends Controller
{
    protected $permissionRepository;

    /**
     * PermissionController constructor.
     *
     * @param \App\Repositories\Auth\Permission\PermissionRepository $permissionRepository
     */
    public function __construct(PermissionRepository $permissionRepository)
    {
        $permissions = $permissionRepository->makeModel()::PERMISSIONS;

        $this->middleware('permission:' . $permissions['index'], ['only' => 'index']);
        $this->middleware('permission:' . $permissions['show'], ['only' => 'show']);

        $this->permissionRepository = $permissionRepository;
    }

    /**
     * @api                {get} /auth/permissions Get all permissions
     * @apiName            get-all-permissions
     * @apiGroup           Permission
     * @apiVersion         1.0.0
     * @apiPermission      Authenticated User
     * @apiUse             PermissionsResponse
     *
     * @param \Dingo\Api\Http\Request $request
     *
     * @return \Dingo\Api\Http\Response
     */
    public function index(Request $request)
    {
        $this->permissionRepository->pushCriteria(new RequestCriteria($request));
        return $this->paginatorOrCollection($this->permissionRepository->paginate(), new PermissionTransformer);
    }

    /**
     * @api                {get} /auth/permissions/{id} Show permission
     * @apiName            show-permission
     * @apiGroup           Permission
     * @apiVersion         1.0.0
     * @apiPermission      Authenticated User
     * @apiUse             PermissionResponse
     *
     * @param \Dingo\Api\Http\Request $request
     *
     * @return \Dingo\Api\Http\Response
     */
    public function show(Request $request)
    {
        $this->permissionRepository->pushCriteria(new RequestCriteria($request));
        $p = $this->permissionRepository->find($this->decodeId($request));
        return $this->item($p, new PermissionTransformer);
    }

}