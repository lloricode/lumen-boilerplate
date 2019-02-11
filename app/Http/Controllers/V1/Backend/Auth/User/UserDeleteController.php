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
 * Class UserDeleteController
 *
 * @package App\Http\Controllers\V1\Backend\Auth\User
 */
class UserDeleteController extends Controller
{
    protected $userRepository;
    protected $userTransformer;

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
        $this->userTransformer = app(UserTransformer::class);
    }

    /**
     * @api                {put} /auth/users/{id}/restore Restore user
     * @apiName            restore-user
     * @apiGroup           UserDelete
     * @apiVersion         1.0.0
     * @apiPermission      Authenticated User
     * @apiUse             UserResponse
     *
     * @param \Dingo\Api\Http\Request $request
     *
     * @return \Dingo\Api\Http\Response
     */
    public function restore(Request $request)
    {
        $user = $this->userRepository->restore($this->decodeId($request));
        return $this->response->item($user, $this->userTransformer, ['key' => 'users'])
            ->addMeta('include', $this->userTransformer->getAvailableIncludes());
    }

    /**
     * @api                {get} /auth/users/deleted Get all deleted users
     * @apiName            get-all-deleted-users
     * @apiGroup           UserDelete
     * @apiVersion         1.0.0
     * @apiPermission      Authenticated User
     * @apiUse             UsersDeletedResponse
     *
     * @param \Dingo\Api\Http\Request $request
     *
     * @return \Dingo\Api\Http\Response
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function deleted(Request $request)
    {
        $this->userRepository->pushCriteria(new OnlyTrashedCriteria);
        $this->userRepository->pushCriteria(new RequestCriteria($request));
        return $this->paginatorOrCollection($this->userRepository->paginate(), $this->userTransformer,
            ['key' => 'users'])
            ->addMeta('include', $this->userTransformer->getAvailableIncludes());
    }

    /**
     * @api                {delete} /auth/users/{id} Purge user
     * @apiName            purge-user
     * @apiGroup           UserDelete
     * @apiVersion         1.0.0
     * @apiPermission      Authenticated User
     * @apiUse             NoContentResponse
     *
     * @param \Dingo\Api\Http\Request $request
     *
     * @return \Dingo\Api\Http\Response
     */
    public function purge(Request $request)
    {
        $this->userRepository->forceDelete($this->decodeId($request));
        return $this->response->noContent();
    }
}