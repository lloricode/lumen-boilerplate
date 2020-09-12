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
use Illuminate\Http\Request;
use Prettus\Repository\Criteria\RequestCriteria;

/**
 * Class PermissionController
 *
 * @package App\Http\Controllers\V1\Backend\Auth\Permission
 */
class PermissionController extends Controller
{
    protected PermissionRepository $permissionRepository;

    /**
     *
     * @OA\Get(
     *     path="/samplesss/{category}/things",
     *     operationId="/samplesss/category/things",
     *     tags={"yourtag"},
     *     @OA\Parameter(
     *         name="category",
     *         in="path",
     *         description="The category parameter in path",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="criteria",
     *         in="query",
     *         description="Some optional other parameter",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Returns some sample category things",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *         response="400",
     *         description="Error: Bad request. When required parameters were not supplied.",
     *     ),
     * )
     * PermissionController constructor.
     *
     * @param  \App\Repositories\Auth\Permission\PermissionRepository  $permissionRepository
     */
    public function __construct(PermissionRepository $permissionRepository)
    {
        $permissions = $permissionRepository->makeModel()::PERMISSIONS;

        $this->middleware('permission:'.$permissions['index'], ['only' => 'index']);
        $this->middleware('permission:'.$permissions['show'], ['only' => 'show']);

        $this->permissionRepository = $permissionRepository;
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Spatie\Fractal\Fractal
     * @api                {get} /auth/permissions Get all permissions
     * @apiName            get-all-permissions
     * @apiGroup           Permission
     * @apiVersion         1.0.0
     * @apiPermission      Authenticated User
     * @apiUse             PermissionsResponse
     *
     */
    public function index(Request $request)
    {
        $this->permissionRepository->pushCriteria(new RequestCriteria($request));
        return $this->fractal($this->permissionRepository->paginate(), new PermissionTransformer());
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $id
     *
     * @return \Spatie\Fractal\Fractal
     * @api                {get} /auth/permissions/{id} Show permission
     * @apiName            show-permission
     * @apiGroup           Permission
     * @apiVersion         1.0.0
     * @apiPermission      Authenticated User
     * @apiUse             PermissionResponse
     *
     */
    public function show(Request $request, string $id)
    {
        $this->permissionRepository->pushCriteria(new RequestCriteria($request));
        $p = $this->permissionRepository->findByRouteKeyName($id);
        return $this->fractal($p, new PermissionTransformer());
    }

}