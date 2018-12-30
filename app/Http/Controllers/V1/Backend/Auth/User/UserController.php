<?php

namespace App\Http\Controllers\V1\Backend\Auth\User;

use App\Http\Controllers\Controller;
use App\Repositories\Auth\User\UserRepository;
use App\Transformers\Auth\UserTransformer;
use Dingo\Api\Http\Request;
use Prettus\Repository\Criteria\RequestCriteria;

/**
 * User resource representation.
 *
 * @Resource("User Management", uri="/auth/users")
 */
class UserController extends Controller
{
    protected $userRepository;

    /**
     * UserController constructor.
     *
     * @param \App\Repositories\Auth\User\UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $permissions = $userRepository->resolveModel()::PERMISSIONS;

        $this->middleware('permission:' . $permissions['index'], ['only' => 'index']);
        $this->middleware('permission:' . $permissions['create'], ['only' => 'store']);
        $this->middleware('permission:' . $permissions['show'], ['only' => 'show']);
        $this->middleware('permission:' . $permissions['update'], ['only' => 'update']);
        $this->middleware('permission:' . $permissions['destroy'], ['only' => 'destroy']);

        $this->userRepository = $userRepository;
    }

    /**
     * Get all users.
     *
     * @param \Dingo\Api\Http\Request $request
     *
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     * @return \Dingo\Api\Http\Response
     * @Get("/")
     * @Versions({"v1"})
     * @Response(200, body={"data":{{"type":"users","id":"X4WYnoOAkjKw0QzZoQ9Dx3RZyvmMl1Gr","attributes":
     *     {"first_name":"Bettie","last_name":"Tremblay","email":"ferry.lelah@hotmail.com",
     *     "created_at":"29/12/201810:46:35AM","created_at_readable":"33minutesago",
     *     "created_at_tz":"29/12/201802:46:35AM","created_at_readable_tz":"33minutesago",
     *     "updated_at":"29/12/201810:46:35AM","updated_at_readable":"33minutesago",
     *     "updated_at_tz":"29/12/201802:46:35AM","updated_at_readable_tz":"33minutesago"}}},
     *     "meta":{"pagination":{"total":53,"count":8,"per_page":15,"current_page":4,"total_pages":4}},
     *     "links":{"self":"http://lumen-dingo-boilerplate.test/auth/users?page=4",
     *     "first":"http://lumen-dingo-boilerplate.test/auth/users?page=1",
     *     "prev":"http://lumen-dingo-boilerplate.test/auth/users?page=3",
     *     "last":"http://lumen-dingo-boilerplate.test/auth/users?page=4"}})
     * @Parameters({
     *      @Parameter("page", type="integer", required=false, description="Pagination page", default=1),
     *      @Parameter("search", type="string", required=false, description="Search item", default=null),
     *      @Parameter("include", type="string", required=false, description="Include relationship", default=null)
     * })
     */
    public function index(Request $request)
    {
        $this->userRepository->pushCriteria(new RequestCriteria($request));
        return $this->response->paginator($this->userRepository->paginate(), new UserTransformer, ['key' => 'users']);
    }

    /**
     * Show user.
     *
     * @param \Dingo\Api\Http\Request $request
     *
     * @return mixed
     * @Get("/{id}")
     * @Versions({"v1"})
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
    public function show(Request $request)
    {
        $user = $this->userRepository->find($this->decodeId($request));
        return $this->response->item($user, new UserTransformer, ['key' => 'users']);
    }

    /**
     * Store user.
     *
     * @param \Dingo\Api\Http\Request $request
     *
     * @return mixed
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     * @Post("/")
     * @Versions({"v1"})
     * @Request({
     *     "first_name": "Lloric",
     *     "last_name": "Garcia",
     *     "email": "lloricode@gmail.com",
     *     "password": "secret"
     * }, headers={"Content-Type": "application/x-www-form-urlencoded"})
     * @Response(201, body={"data":{"type":"users","id":"BX0gNpxGL2ymj8zgD9lqnrVZwQaMDkOY","attributes":
     *     {"first_name":"Lloric","last_name":"Garcia","email":"lloricode@gmail.com",
     *     "created_at":"29/12/201810:46:30AM","created_at_readable":"1hourago",
     *     "created_at_tz":"29/12/201802:46:30AM","created_at_readable_tz":"1hourago",
     *     "updated_at":"29/12/201810:46:30AM","updated_at_readable":"1hourago",
     *     "updated_at_tz":"29/12/201802:46:30AM","updated_at_readable_tz":"1hourago"}}})
     */
    public function store(Request $request)
    {
        return $this->response->item($this->userRepository->create($request->only([
            'first_name',
            'last_name',
            'email',
            'password',
        ])), new UserTransformer, ['key' => 'users'])
            ->statusCode(201);
    }

    /**
     * Update user.
     *
     * @param \Dingo\Api\Http\Request $request
     *
     * @return mixed
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     * @Put("/{id}")
     * @Versions({"v1"})
     * @Request({
     *     "first_name": "Lloric",
     *     "last_name": "Garcia",
     *     "email": "lloricode@gmail.com",
     *     "password": "secret"
     * }, headers={"Content-Type": "application/x-www-form-urlencoded"})
     * @Response(200, body={"data":{"type":"users","id":"BX0gNpxGL2ymj8zgD9lqnrVZwQaMDkOY","attributes":
     *     {"first_name":"Lloric","last_name":"Garcia","email":"lloricode@gmail.com",
     *     "created_at":"29/12/201810:46:30AM","created_at_readable":"1hourago",
     *     "created_at_tz":"29/12/201802:46:30AM","created_at_readable_tz":"1hourago",
     *     "updated_at":"29/12/201810:46:30AM","updated_at_readable":"1hourago",
     *     "updated_at_tz":"29/12/201802:46:30AM","updated_at_readable_tz":"1hourago"}}})
     * @Parameters({
     *      @Parameter("include", type="string", required=false, description="Include relationship", default=null)
     * })
     */
    public function update(Request $request)
    {
        $user = $this->userRepository->update($request->only([
            'first_name',
            'last_name',
            'email',
            'password',
        ]), $this->decodeId($request));
        return $this->response->item($user, new UserTransformer, ['key' => 'users']);
    }

    /**
     * Destroy user.
     *
     * @param \Dingo\Api\Http\Request $request
     *
     * @return mixed
     * @Delete("/{id}")
     * @Versions({"v1"})
     * @Response(204,)
     */
    public function destroy(Request $request)
    {
        $id = $this->decodeId($request);
        if (app('auth')->id() == $id) {
            $this->response->errorForbidden('You cannot delete your self.');
        }

        $this->userRepository->delete($id);
        return $this->response->noContent();
    }
}
