<?php

namespace App\Http\Controllers\Backend\Auth\User;

use App\Http\Controllers\Controller;
use App\Repositories\Auth\User\UserRepository;
use App\Transformers\Auth\UserTransformer;
use Illuminate\Http\Request;
use Prettus\Repository\Criteria\RequestCriteria;

/**
 * Class UserController
 *
 * @package App\Http\Controllers\Backend\Auth\User
 * @group   User Management
 */
class UserController extends Controller
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $permissions = app($userRepository->model())::PERMISSIONS;

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
     * @param \Illuminate\Http\Request $request
     *
     * @return mixed
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     * @authenticated
     * @responseFile responses/auth/users.get.json
     */
    public function index(Request $request)
    {
        $this->userRepository->pushCriteria(new RequestCriteria($request));

        return $this->response->paginator($this->userRepository->model()::paginate(), new UserTransformer,
            ['key' => 'users']);
    }

    /**
     * Show user.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return mixed
     * @authenticated
     * @responseFile responses/auth/user.get.json
     */
    public function show(Request $request)
    {
        $user = $this->userRepository->find($this->decodeId($request));
        return $this->response->item($user, new UserTransformer, ['key' => 'users']);
    }

    /**
     * Store user.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     * @authenticated
     * @bodyParam    first_name string required First name. Example: Lloric
     * @bodyParam    last_name string required Last name. Example: Garcia
     * @bodyParam    email string required A valid email and unique. Example: lloricode@gmail.com
     * @bodyParam    password string required Password Example: secret
     * @responseFile 201 responses/auth/user.get.json
     */
    public function store(Request $request)
    {
//        $this->userRepository->setPresenter(UserPresenter::class);
        return $this->response->item($this->userRepository->create($request->all()), new UserTransformer,
            ['key' => 'users'])
            ->statusCode(201);
    }

    /**
     * Update user.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return mixed
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     * @authenticated
     * @bodyParam    first_name string First name. Example: Lloric
     * @bodyParam    last_name string Last name. Example: Garcia
     * @bodyParam    email string A valid email and unique. Example: lloricode@gmail.com
     * @bodyParam    password string Password Example: secret
     * @responseFile responses/auth/user.get.json
     */
    public function update(Request $request)
    {
//        $this->userRepository->setPresenter(UserPresenter::class);
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
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     * @authenticated
     * @responseFile 204 responses/no-content.get.json
     */
    public function destroy(Request $request)
    {
        $id = $this->decodeId($request);
        if (app('auth')->id() == $id) {
            abort(422, 'You cannot delete your self.');
        }

        $this->userRepository->delete($id);
        return $this->response->noContent();
    }
}
