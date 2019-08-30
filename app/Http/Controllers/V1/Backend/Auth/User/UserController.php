<?php

namespace App\Http\Controllers\V1\Backend\Auth\User;

use App\Http\Controllers\Controller;
use App\Repositories\Auth\User\UserRepository;
use App\Transformers\Auth\UserTransformer;
use Dingo\Api\Http\Request;
use Prettus\Repository\Criteria\RequestCriteria;

/**
 * Class UserController
 *
 * @package App\Http\Controllers\V1\Backend\Auth\User
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
        $permissions = $userRepository->makeModel()::PERMISSIONS;

        $this->middleware('permission:' . $permissions['index'], ['only' => 'index']);
        $this->middleware('permission:' . $permissions['create'], ['only' => 'store']);
        $this->middleware('permission:' . $permissions['show'], ['only' => 'show']);
        $this->middleware('permission:' . $permissions['update'], ['only' => 'update']);
        $this->middleware('permission:' . $permissions['destroy'], ['only' => 'destroy']);

        $this->userRepository = $userRepository;
    }

    /**
     * @api                {get} /auth/users Get all users
     * @apiName            get-all-users
     * @apiGroup           User
     * @apiVersion         1.0.0
     * @apiPermission      Authenticated User
     * @apiUse             UsersResponse
     *
     * @param \Dingo\Api\Http\Request $request
     *
     * @return \Dingo\Api\Http\Response
     */
    public function index(Request $request)
    {
        $this->userRepository->pushCriteria(new RequestCriteria($request));
        return $this->paginatorOrCollection($this->userRepository->paginate(), new UserTransformer);
    }

    /**
     * @api                {get} /auth/users/{id} Show user
     * @apiName            show-user
     * @apiGroup           User
     * @apiVersion         1.0.0
     * @apiPermission      Authenticated User
     * @apiUse             UserResponse
     *
     * @param string $id
     *
     * @return \Dingo\Api\Http\Response
     */
    public function show(string $id)
    {
        $user = $this->userRepository->find($this->decodeHash($id));
        return $this->item($user, new UserTransformer);
    }

    /**
     * @param  \Dingo\Api\Http\Request  $request
     *
     * @return \Dingo\Api\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     * @api                {post} /auth/users Store user
     * @apiName            store-user
     * @apiGroup           User
     * @apiVersion         1.0.0
     * @apiPermission      Authenticated User
     * @apiUse             UserCreatedResponse
     * @apiParam {String} first_name (required)
     * @apiParam {String} last_name (required)
     * @apiParam {String} email (required)
     * @apiParam {String} password (required)
     *
     */
    public function store(Request $request)
    {
        $attributes = $this->validate($request, [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
        ]);

        $attributes['password'] = app('hash')->make($attributes['password']);

        return $this->item($this->userRepository->create($attributes), new UserTransformer)
            ->statusCode(201);
    }

    /**
     * @param  \Dingo\Api\Http\Request  $request
     * @param  string  $id
     *
     * @return \Dingo\Api\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     * @api                {put} /auth/users/ Update user
     * @apiName            update-user
     * @apiGroup           User
     * @apiVersion         1.0.0
     * @apiPermission      Authenticated User
     * @apiUse             UserResponse
     * @apiParam {String} first_name
     * @apiParam {String} last_name
     * @apiParam {String} email
     * @apiParam {String} password
     *
     */
    public function update(Request $request, string $id)
    {
        $attributes = $this->validate($request, [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
        ]);

        $attributes['password'] = app('hash')->make($attributes['password']);

        $user = $this->userRepository->update($attributes, $this->decodeHash($id));
        return $this->item($user, new UserTransformer);
    }


    /**
     * @api                {delete} /auth/users/{id} Destroy user
     * @apiName            destroy-user
     * @apiGroup           User
     * @apiVersion         1.0.0
     * @apiPermission      Authenticated User
     * @apiUse             NoContentResponse
     *
     * @param string $id
     *
     * @return \Dingo\Api\Http\Response
     */
    public function destroy(string $id)
    {
        $id = $this->decodeHash($id);
        if (app('auth')->id() == $id) {
            $this->response->errorForbidden('You cannot delete your self.');
        }

        $this->userRepository->delete($id);
        return $this->response->noContent();
    }
}
