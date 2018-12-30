<?php
/**
 * Created by PhpStorm.
 * User: Lloric Mayuga Garcia <lloricode@gmail.com>
 * Date: 12/2/18
 * Time: 4:52 PM
 */

namespace App\Http\Controllers\V1\Backend\Auth\User;

use App\Http\Controllers\Controller;
use App\Transformers\Auth\UserTransformer;

/**
 * User access representation.
 *
 * @Resource("User Access", uri="/auth")
 */
class UserAccessController extends Controller
{
    /**
     * @api                {get} /auth/profile Get current authenticated user.
     * @apiName            getAuthenticatedUser
     * @apiGroup           User
     * @apiVersion         1.0.0
     *
     * @apiSuccessExample  Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *         "data": {
     *             "type": "users",
     *              "id": "BX0gNpxGL2ymj8zgD9lqnrVZwQaMDkOY",
     *              "attributes": {
     *                   "first_name": "System",
     *                   "last_name": "Root",
     *                   "email": "system@system.com",
     *                   "created_at": "30/12/2018 04:22:50 PM",
     *                   "created_at_readable": "10 hours ago",
     *                   "created_at_tz": "30/12/2018 08:22:50 AM",
     *                   "created_at_readable_tz": "10 hours ago",
     *                   "updated_at": "30/12/2018 04:22:50 PM",
     *                   "updated_at_readable": "10 hours ago",
     *                   "updated_at_tz": "30/12/2018 08:22:50 AM",
     *                   "updated_at_readable_tz": "10 hours ago"
     *               }
     *          }
     *     }
     *
     * @return \Dingo\Api\Http\Response
     */
    public function profile()
    {
        return $this->response->item($this->user(), new UserTransformer, ['key' => 'users']);
    }
}