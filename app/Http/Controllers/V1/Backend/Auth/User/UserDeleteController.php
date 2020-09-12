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
use Illuminate\Http\Request;
use Prettus\Repository\Criteria\RequestCriteria;

/**
 * Class UserDeleteController
 *
 * @package App\Http\Controllers\V1\Backend\Auth\User
 */
class UserDeleteController extends Controller
{
    protected UserRepository $userRepository;

    /**
     * @OA\Get(
     *     path="/sampxccle/{category}/things",
     *     operationId="/sambvbvple/category/things",
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
     *
     * UserDeleteController constructor.
     *
     * @param  \App\Repositories\Auth\User\UserRepository  $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $permissions = $userRepository->makeModel()::PERMISSIONS;

        $this->middleware('permission:'.$permissions['deleted list'], ['only' => 'deleted']);
        $this->middleware('permission:'.$permissions['restore'], ['only' => 'restore']);
        $this->middleware('permission:'.$permissions['purge'], ['only' => 'purge']);

        $this->userRepository = $userRepository;
    }

    /**
     * @param  string  $id
     *
     * @return \Spatie\Fractal\Fractal
     * @api                {put} /auth/users/{id}/restore Restore user
     * @apiName            restore-user
     * @apiGroup           UserDelete
     * @apiVersion         1.0.0
     * @apiPermission      Authenticated User
     * @apiUse             UserResponse
     *
     */
    public function restore(string $id)
    {
        $this->userRepository->pushCriteria(new OnlyTrashedCriteria());
        $user = $this->userRepository->findByRouteKeyName($id);

        if (blank($user)) {
            abort(404);
        }

        $user = $this->userRepository->restore($user->getKey());
        return $this->fractal($user, new UserTransformer());
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Spatie\Fractal\Fractal
     * @api                {get} /auth/users/deleted Get all deleted users
     * @apiName            get-all-deleted-users
     * @apiGroup           UserDelete
     * @apiVersion         1.0.0
     * @apiPermission      Authenticated User
     * @apiUse             UsersDeletedResponse
     *
     */
    public function deleted(Request $request)
    {
        $this->userRepository->pushCriteria(new OnlyTrashedCriteria());
        $this->userRepository->pushCriteria(new RequestCriteria($request));
        return $this->fractal($this->userRepository->paginate(), new UserTransformer());
    }

    /**
     * @param  string  $id
     *
     * @return \Illuminate\Http\Response|\Laravel\Lumen\Http\ResponseFactory
     * @api                {delete} /auth/users/{id} Purge user
     * @apiName            purge-user
     * @apiGroup           UserDelete
     * @apiVersion         1.0.0
     * @apiPermission      Authenticated User
     * @apiUse             NoContentResponse
     *
     */
    public function purge(string $id)
    {
        $this->userRepository->pushCriteria(new OnlyTrashedCriteria());
        $user = $this->userRepository->findByRouteKeyName($id);

        if (blank($user)) {
            abort(404);
        }

        $this->userRepository->forceDelete($user->getKey());
        return response('', 204);
    }
}