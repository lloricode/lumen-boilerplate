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
use App\Presenters\Auth\UserPresenter;
use App\Repositories\Auth\User\UserRepository;
use Illuminate\Http\Request;

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
        $permissions = app($userRepository->model())::PERMISSIONS;

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
        $this->userRepository->setPresenter(UserPresenter::class);
        return $this->userRepository->restore($this->decodeId($request));
    }

    /**
     * Get all deleted users.
     *
     * @return mixed
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     * @authenticated
     * @responseFile responses/auth/users-deleted.get.json
     */
    public function deleted()
    {
        $this->userRepository->pushCriteria(new OnlyTrashedCriteria);
        $this->userRepository->setPresenter(UserPresenter::class);
        return $this->userRepository->paginate();
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
        return response('', 204);
    }
}