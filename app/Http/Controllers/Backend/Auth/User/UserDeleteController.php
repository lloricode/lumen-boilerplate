<?php
/**
 * Created by PhpStorm.
 * User: Lloric Mayuga Garcia <lloricode@gmail.com>
 * Date: 12/2/18
 * Time: 4:08 PM
 */

namespace App\Http\Controllers\Backend\Auth\User;

use App\Criterion\Eloquent\OnlyTrashedCriteria;
use App\Http\Controllers\Controller;
use App\Repositories\Auth\User\UserRepository;
use App\Transformers\Auth\UserTransformer;
use Dingo\Api\Http\Request;
use Prettus\Repository\Criteria\RequestCriteria;

/**
 * Class UserDeleteController
 *
 * @package App\Http\Controllers\Backend\Auth\User
 * @group   User Management
 */
class UserDeleteController extends Controller
{
    protected $userRepository;

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
     * @param \Illuminate\Http\Request $request
     *
     * @return mixed
     * @authenticated
     * @responseFile responses/auth/user.get.json
     */
    public function restore(Request $request)
    {
        $user = $this->userRepository->restore($this->decodeId($request));
        return $this->item($user, new UserTransformer, ['key' => 'users']);
    }

    /**
     * Get all deleted users.
     *
     * @return mixed
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     * @authenticated
     * @responseFile responses/auth/users-deleted.get.json
     */
    public function deleted(Request $request)
    {
        $this->userRepository->pushCriteria(new OnlyTrashedCriteria);
        $this->userRepository->pushCriteria(new RequestCriteria($request));
        return $this->paginator($this->userRepository->paginate(), new UserTransformer(),
            ['key' => 'users']);
    }

    /**
     * Purge user.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     * @authenticated
     * @responseFile 204 responses/no-content.get.json
     */
    public function purge(Request $request)
    {
        $this->userRepository->forceDelete($this->decodeId($request));
        return $this->noContent();
    }
}