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