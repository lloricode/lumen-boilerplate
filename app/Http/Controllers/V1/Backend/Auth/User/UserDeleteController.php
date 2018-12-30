<?php
/**
 * Created by PhpStorm.
 * User: Lloric Mayuga Garcia <lloricode@gmail.com>
 * Date: 12/2/18
 * Time: 4:08 PM
 */

namespace App\Http\Controllers\V1\Backend\Auth\User;

use App\Criterion\Eloquent\OnlyTrashedCriteria;
use App\Http\Controllers\Controller;
use App\Repositories\Auth\User\UserRepository;
use App\Transformers\Auth\UserTransformer;
use Dingo\Api\Http\Request;
use Prettus\Repository\Criteria\RequestCriteria;

/**
 * User deletes representation.
 *
 * @Resource("User Deletes", uri="/auth/users")
 */
class UserDeleteController extends Controller
{
    protected $userRepository;

    /**
     * UserDeleteController constructor.
     *
     * @param \App\Repositories\Auth\User\UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $permissions = $userRepository->resolveModel()::PERMISSIONS;

        $this->middleware('permission:' . $permissions['deleted list'], ['only' => 'deleted']);
        $this->middleware('permission:' . $permissions['restore'], ['only' => 'restore']);
        $this->middleware('permission:' . $permissions['purge'], ['only' => 'purge']);

        $this->userRepository = $userRepository;
    }

    /**
     * Restore user.
     *
     * @param \Dingo\Api\Http\Request $request
     *
     * @return mixed
     * @Put("/{id}/restore")
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
    public function restore(Request $request)
    {
        $user = $this->userRepository->restore($this->decodeId($request));
        return $this->response->item($user, new UserTransformer, ['key' => 'users']);
    }

    /**
     * Get all deleted users.
     *
     * @param \Dingo\Api\Http\Request $request
     *
     * @return mixed
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     * @Get("/deleted")
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
    public function deleted(Request $request)
    {
        $this->userRepository->pushCriteria(new OnlyTrashedCriteria);
        $this->userRepository->pushCriteria(new RequestCriteria($request));
        return $this->response->paginator($this->userRepository->paginate(), new UserTransformer(),
            ['key' => 'users']);
    }

    /**
     * Purge user.
     *
     * @param \Dingo\Api\Http\Request $request
     *
     * @return mixed
     * @Delete("/{id}/purge")
     * @Versions({"v1"})
     * @Response(204)
     */
    public function purge(Request $request)
    {
        $this->userRepository->forceDelete($this->decodeId($request));
        return $this->response->noContent();
    }
}