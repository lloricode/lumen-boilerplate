<?php

namespace App\Http\Controllers\V1\Backend\Auth\User;

use App\Http\Controllers\Controller;
use App\Repositories\Auth\User\UserRepository;
use App\Transformers\Auth\UserTransformer;
use Illuminate\Http\Request;
use Prettus\Repository\Criteria\RequestCriteria;

/**
 * Class UserController
 *
 * @package App\Http\Controllers\V1\Backend\Auth\User
 */
class UserController extends Controller
{
    protected UserRepository $userRepository;

    /**
     * UserController constructor.
     *
     * @param  \App\Repositories\Auth\User\UserRepository  $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $permissions = $userRepository->makeModel()::PERMISSIONS;

        $this->middleware('permission:'.$permissions['index'], ['only' => 'index']);
        $this->middleware('permission:'.$permissions['create'], ['only' => 'store']);
        $this->middleware('permission:'.$permissions['show'], ['only' => 'show']);
        $this->middleware('permission:'.$permissions['update'], ['only' => 'update']);
        $this->middleware('permission:'.$permissions['destroy'], ['only' => 'destroy']);

        $this->userRepository = $userRepository;
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Spatie\Fractal\Fractal
     * @api                {get} /auth/users Get all users
     * @apiName            get-all-users
     * @apiGroup           User
     * @apiVersion         1.0.0
     * @apiPermission      Authenticated User
     * @apiUse             UsersResponse
     *
     */
    public function index(Request $request)
    {
        $this->userRepository->pushCriteria(new RequestCriteria($request));
        return $this->fractal($this->userRepository->paginate(), new UserTransformer());
    }

    /**
     * @param  string  $id
     *
     * @return \Spatie\Fractal\Fractal
     * @api                {get} /auth/users/{id} Show user
     * @apiName            show-user
     * @apiGroup           User
     * @apiVersion         1.0.0
     * @apiPermission      Authenticated User
     * @apiUse             UserResponse
     *
     */
    public function show(string $id)
    {
        $user = $this->userRepository->findByRouteKeyName($id);

        if (blank($user)) {
            abort(404);
        }

        return $this->fractal($user, new UserTransformer());
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
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
        $attributes = $this->validate(
            $request,
            [
                'first_name' => 'required|string',
                'last_name' => 'required|string',
                'email' => 'required|email|unique:users,email',
                'password' => 'required',
            ]
        );

        $attributes['password'] = app('hash')->make($attributes['password']);

        return $this->fractal($this->userRepository->create($attributes), new UserTransformer())
            ->respond(201);
    }

    /**
     * @OA\Get(
     *     path="/sampzzle/{category}/things",
     *     operationId="/samxxxple/category/things",
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
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $id
     *
     * @return \Spatie\Fractal\Fractal
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
        $attributes = $this->validate(
            $request,
            [
                'first_name' => 'required|string',
                'last_name' => 'required|string',
                'email' => 'required|email|unique:users,email',
                'password' => 'required',
            ]
        );

        $attributes['password'] = app('hash')->make($attributes['password']);

        $user = $this->userRepository->update($attributes, $this->userRepository->findByRouteKeyName($id)->getKey());
        return $this->fractal($user, new UserTransformer());
    }


    /**
     * @param  string  $id
     *
     * @return \Illuminate\Http\Response|\Laravel\Lumen\Http\ResponseFactory
     * @api                {delete} /auth/users/{id} Destroy user
     * @apiName            destroy-user
     * @apiGroup           User
     * @apiVersion         1.0.0
     * @apiPermission      Authenticated User
     * @apiUse             NoContentResponse
     *
     */
    public function destroy(string $id)
    {
        $id = $this->userRepository->findByRouteKeyName($id)->getKey();
        if (app('auth')->id() == $id) {
            return response(['message' => 'You cannot delete your self.'], 403);
        }

        $this->userRepository->delete($id);
        return response('', 204);
    }
}
