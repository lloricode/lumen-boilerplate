<?php

namespace App\Http\Controllers\V1\Backend\Auth\User;

use App\Criterion\Eloquent\OnlyTrashedCriteria;
use App\Http\Controllers\Controller;
use App\Repositories\Auth\User\UserRepository;
use App\Transformers\Auth\UserTransformer;
use Illuminate\Http\Request;
use Prettus\Repository\Criteria\RequestCriteria;

class UserDeleteController extends Controller
{
    protected UserRepository $userRepository;

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