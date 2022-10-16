<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1\Frontend\User;

use App\Http\Controllers\Controller;
use App\Transformers\Auth\UserTransformer;

class UserAccessController extends Controller
{
    /**
     * @OA\Get(
     *     path="/profile",
     *     tags={"Access"},
     *     summary="Get current logged in user profile",
     *     security={{"passport" : {}}},
     *     @OA\Response(
     *         response="200",
     *         description="Returns some sample category things",
     *         @OA\JsonContent()
     *     )
     * )
     * @return \Spatie\Fractal\Fractal
     * @api                {get} /profile Get current authenticated user
     * @apiName            get-authenticated-user
     * @apiGroup           UserAccess
     * @apiVersion         1.0.0
     * @apiPermission      Authenticated User
     * @apiUse             UserResponse
     *
     */
    public function profile()
    {
        return $this->fractal(auth()->user(), new UserTransformer());
    }
}
