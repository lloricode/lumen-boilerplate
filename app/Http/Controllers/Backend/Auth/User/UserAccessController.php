<?php
/**
 * Created by PhpStorm.
 * User: Lloric Mayuga Garcia <lloricode@gmail.com>
 * Date: 12/2/18
 * Time: 4:52 PM
 */

namespace App\Http\Controllers\Backend\Auth\User;

use App\Http\Controllers\Controller;
use App\Transformers\Auth\UserTransformer;

/**
 * Class UserAccessController
 *
 * @package App\Http\Controllers\Backend\Auth\User
 * @group   User Management
 */
class UserAccessController extends Controller
{
    /**
     * Get current authenticated user.
     *
     * @return mixed
     */
    public function profile()
    {
        return $this->item($this->user(), new UserTransformer, ['key' => 'users']);
    }
}