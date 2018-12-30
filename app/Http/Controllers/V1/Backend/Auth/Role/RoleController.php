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
 * Role resource representation.
 *
 * @Resource("Role Management", uri="/auth/roles")
 */
class RoleController extends Controller
{
    protected $roleRepository;

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
     * Get all roles.
     *
     * @param \Dingo\Api\Http\Request $request
     *
     * @return \Dingo\Api\Http\Response
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     * @Get("/")
     * @Versions({"v1"})
     * @Response(200, body={"data":{{"type":"roles","id":"BX0gNpxGL2ymj8zgD9lqnrVZwQaMDkOY",
     *     "attributes":{"name":"system"}},{"type":"roles","id":"X4WYnoOAkjKw0QzZQ6Dx3RZyvmMl1Grq",
     *     "attributes":{"name":"admin"}}},"meta":{"pagination":{"total":2,"count":2,"per_page":15,
     *     "current_page":1,"total_pages":1}},"links":{"self":"http:\/\/lumen-dingo-boilerplate.test\/auth\/roles?page=1",
     *     "first":"http:\/\/lumen-dingo-boilerplate.test\/auth\/roles?page=1",
     *     "last":"http:\/\/lumen-dingo-boilerplate.test\/auth\/roles?page=1"}})
     * @Parameters({
     *      @Parameter("page", type="integer", required=false, description="Pagination page", default=1),
     *      @Parameter("search", type="string", required=false, description="Search item", default=null),
     *      @Parameter("include", type="string", required=false, description="Include relationship", default=null)
     * })
     */
    public function index(Request $request)
    {
        $this->roleRepository->pushCriteria(new RequestCriteria($request));
        return $this->response->paginator($this->roleRepository->paginate(), new RoleTransformer,
            ['key' => 'roles']);
    }

    /**
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     * @authenticated
     * @bodyParam    name string required Role name. Example: test role name
     * @responseFile 201 responses/auth/role.get.json
     */

    /**
     * Store role.
     *
     * @param \Dingo\Api\Http\Request $request
     *
     * @return \Dingo\Api\Http\Response
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     * @Post("/")
     * @Versions({"v1"})
     * @Request({
     *     "name": "executive"
     * }, headers={"Content-Type": "application/x-www-form-urlencoded"})
     * @Response(201, body={"data":{"type":"roles","id":"X0NDx2YlwZ8mep6og6AM3OqoP1nrkWJa",
     *     "attributes":{"name":"executive"},"relationships":{"permissions":{"data":{}}}}})
     */
    public function store(Request $request)
    {
        $role = $this->roleRepository->create([
            'name' => $request->input('name'),
        ]);
        return $this->response->item($role, new RoleTransformer, ['key' => 'roles'])->statusCode(201);
    }

    /**
     * Show role.
     *
     * @param \Dingo\Api\Http\Request $request
     *
     * @return \Dingo\Api\Http\Response
     * @Get("/{id}")
     * @Versions({"v1"})
     * @Response(200, body={"data":{"type":"roles","id":"X0NDx2YlwZ8mep6og6AM3OqoP1nrkWJa",
     *     "attributes":{"name":"executive"},"relationships":{"permissions":{"data":{}}}}})
     * @Parameters({
     *      @Parameter("include", type="string", required=false, description="Include relationship", default=null)
     * })
     */
    public function show(Request $request)
    {
        $role = $this->roleRepository->find($this->decodeId($request));
        return $this->response->item($role, new RoleTransformer, ['key' => 'roles']);
    }

    /**
     * Update role.
     *
     * @param \Dingo\Api\Http\Request $request
     *
     * @return \Dingo\Api\Http\Response
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     * @Put("/{id}")
     * @Versions({"v1"})
     * @Request({
     *     "name": "executive"
     * }, headers={"Content-Type": "application/x-www-form-urlencoded"})
     * @Response(200, body={"data":{"type":"roles","id":"X0NDx2YlwZ8mep6og6AM3OqoP1nrkWJa",
     *     "attributes":{"name":"executive"},"relationships":{"permissions":{"data":{}}}}})
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
     * @param \Dingo\Api\Http\Request $request
     *
     * @return \Dingo\Api\Http\Response
     * @Delete("/{id}")
     * @Response(204)
     */
    public function destroy(Request $request)
    {
        $this->roleRepository->delete($this->decodeId($request));
        return $this->response->noContent();
    }
}