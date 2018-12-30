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
     * Get current authenticated user.
     *
     * @return mixed
     * @Get("/profile")
     * @Versions({"v1"})
     * @Response(200, body={"data":{"type":"users","id":"BX0gNpxGL2ymj8zgD9lqnrVZwQaMDkOY","attributes":
     *     {"first_name":"System","last_name":"Root","email":"system@system.com",
     *     "created_at":"29/12/201810:46:30AM","created_at_readable":"1hourago",
     *     "created_at_tz":"29/12/201802:46:30AM","created_at_readable_tz":"1hourago",
     *     "updated_at":"29/12/201810:46:30AM","updated_at_readable":"1hourago",
     *     "updated_at_tz":"29/12/201802:46:30AM","updated_at_readable_tz":"1hourago"}}})
     * @Parameters({
     *      @Parameter("include", type="string", required=false, description="Include relationship", default=null)
     * })
     */
    public function profile()
    {
        return $this->response->item($this->user(), new UserTransformer, ['key' => 'users']);
    }
}