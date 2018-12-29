<?php

namespace App\Http\Controllers\Backend\Auth\User;

use App\Http\Controllers\Controller;
use App\Repositories\Auth\User\UserRepository;
use App\Transformers\Auth\UserTransformer;
use Dingo\Api\Http\Request;
use Prettus\Repository\Criteria\RequestCriteria;

/**
 * User resource representation.
 *
 * @package App\Http\Controllers\Backend\Auth\User
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
     * Get all users
     *
     * @param \Dingo\Api\Http\Request $request
     *
     * @return \Dingo\Api\Http\Response
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     * @Get("/")
     * @Versions({"v1"})
     * @Request({})
     */
    public function index(Request $request)
    {
        $this->userRepository->pushCriteria(new RequestCriteria($request));
        return $this->paginator(
            $this->userRepository->resolveModel()::paginate(),
            new UserTransformer,
            ['key' => 'users']
        );
    }

    /**
     * Show user
     *
     * @param \Dingo\Api\Http\Request $request
     *
     * @return \Dingo\Api\Http\Response
     */
    public function show(Request $request)
    {
        $user = $this->userRepository->find($this->decodeId($request));
        return $this->item($user, new UserTransformer, ['key' => 'users']);
    }

    /**
     * Store user
     *
     * @param \Dingo\Api\Http\Request $request
     *
     * @return \Dingo\Api\Http\Response
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     * @Post("/")
     * @Versions({"v1"})
     * @Request({
     *     "first_name": "Lloric",
     *     "last_name": "Garcia",
     *     "email": "lloricode@gmail.com",
     *     "password": "secret"
     * }, headers={"Content-Type": "application/x-www-form-urlencoded"})
     */
    public function store(Request $request)
    {
        return $this->item(
            $this->userRepository->create($request->all()),
            new UserTransformer,
            ['key' => 'users']
        )
            ->statusCode(201);
    }

    /**
     * Update user.
     *
     * @param \Dingo\Api\Http\Request $request
     *
     * @return \Dingo\Api\Http\Response
     * @throws \Prettus\Validator\Exceptions\ValidatorException
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
        return $this->item($user, new UserTransformer, ['key' => 'users']);
    }

    /**
     * Destroy user.
     *
     * @param \Dingo\Api\Http\Request $request
     *
     * @return \Dingo\Api\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = $this->decodeId($request);
        if (app('auth')->id() == $id) {
            abort(422, 'You cannot delete your self.');
        }

        $this->userRepository->delete($id);
        return $this->noContent();
    }
}
