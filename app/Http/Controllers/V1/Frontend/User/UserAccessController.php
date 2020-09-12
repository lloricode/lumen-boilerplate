<?php
/**
 * Created by PhpStorm.
 * User: Lloric Mayuga Garcia <lloricode@gmail.com>
 * Date: 12/2/18
 * Time: 4:52 PM
 */

namespace App\Http\Controllers\V1\Frontend\User;

use App\Http\Controllers\Controller;
use App\Transformers\Auth\UserTransformer;

/**
 * Class UserAccessController
 *
 * @package App\Http\Controllers\V1\Backend\Auth\User
 */
class UserAccessController extends Controller
{
    /**
     * @OA\Get(
     *     path="/profile",
     *     tags={"Authorization"},
     *     summary="Get current logged in user profile",
     *     security={{"passport":{}}},
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