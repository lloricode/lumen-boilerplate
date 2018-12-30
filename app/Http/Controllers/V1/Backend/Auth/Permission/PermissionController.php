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
 * Permission resource representation.
 *
 * @Resource("Permission Management", uri="/auth/permissions")
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
        $permissions = $permissionRepository->resolveModel()::PERMISSIONS;

        $this->middleware('permission:' . $permissions['index'], ['only' => 'index']);
        $this->middleware('permission:' . $permissions['show'], ['only' => 'show']);

        $this->permissionRepository = $permissionRepository;
    }

    /**
     * Get all permissions.
     *
     * @param \Dingo\Api\Http\Request $request
     *
     * @return \Dingo\Api\Http\Response
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     * @Get("/")
     * @Versions({"v1"})
     * @Response(200, body={"data":{{"type":"permissions","id":"BX0gNpxGL2ymj8zgD9lqnrVZwQaMDkOY",
     *     "attributes":{"name":"view backend"}}},"meta":{"pagination":{"total":16,
     *     "count":1,"per_page":1,"current_page":1,"total_pages":16}},
     *     "links":{"self":"http:\/\/lumen-dingo-boilerplate.test\/auth\/permissions?page=1",
     *     "first":"http:\/\/lumen-dingo-boilerplate.test\/auth\/permissions?page=1",
     *     "next":"http:\/\/lumen-dingo-boilerplate.test\/auth\/permissions?page=2",
     *     "last":"http:\/\/lumen-dingo-boilerplate.test\/auth\/permissions?page=16"}})
     * @Parameters({
     *      @Parameter("page", type="integer", required=false, description="Pagination page", default=1),
     *      @Parameter("search", type="string", required=false, description="Search item", default=null),
     *      @Parameter("include", type="string", required=false, description="Include relationship", default=null)
     * })
     */
    public function index(Request $request)
    {
        $this->permissionRepository->pushCriteria(new RequestCriteria($request));
        return $this->response->paginator($this->permissionRepository->paginate(), new PermissionTransformer,
            ['key' => 'permissions']);
    }

    /**
     * Show permission.
     *
     * @param \Dingo\Api\Http\Request $request
     *
     * @return \Dingo\Api\Http\Response
     * @Get("/{id}")
     * @Versions({"v1"})
     * @Response(200, body={"data":{"type":"permissions","id":"BX0gNpxGL2ymj8zgD9lqnrVZwQaMDkOY",
     *     "attributes":{"name":"view backend"}}})
     * @Parameters({
     *      @Parameter("include", type="string", required=false, description="Include relationship", default=null)
     * })
     */
    public function show(Request $request)
    {
        $p = $this->permissionRepository->find($this->decodeId($request));
        return $this->response->item($p, new PermissionTransformer, ['key' => 'permissions']);
    }

}