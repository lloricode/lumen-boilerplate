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

    /**
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
     * @return \Dingo\Api\Http\Response
     * @throws \Prettus\Repository\Exceptions\RepositoryException
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
        $user = $this->userRepository->restore($this->decodeHash($id));
        return $this->item($user, new UserTransformer);
    }

    /**
     * @param  \Dingo\Api\Http\Request  $request
     *
     * @return \Dingo\Api\Http\Response
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
        $this->userRepository->pushCriteria(new OnlyTrashedCriteria);
        $this->userRepository->pushCriteria(new RequestCriteria($request));
        return $this->paginatorOrCollection($this->userRepository->paginate(), new UserTransformer);
    }

    /**
     * @param  string  $id
     *
     * @return \Dingo\Api\Http\Response
     * @throws \Prettus\Repository\Exceptions\RepositoryException
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
        $this->userRepository->forceDelete($this->decodeHash($id));
        return $this->response->noContent();
    }
}