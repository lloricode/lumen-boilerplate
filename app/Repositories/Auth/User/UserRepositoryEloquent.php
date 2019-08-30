<?php
/**
 * Created by PhpStorm.
 * User: Lloric Mayuga Garcia <lloricode@gmail.com>
 * Date: 11/24/18
 * Time: 3:23 PM
 */

namespace App\Repositories\Auth\User;

use App\Models\Auth\User\User;
use App\Repositories\BaseRepository;
use Prettus\Repository\Events\RepositoryEntityUpdated;

/**
 * Class UserRepositoryEloquent
 *
 * @package App\Repositories\Auth\User
 */
class UserRepositoryEloquent extends BaseRepository implements UserRepository
{

    protected $fieldSearchable = [
        'first_name' => 'like',
        'last_name' => 'like',
        'email' => 'like',
    ];

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return User::class;
    }


    /**
     * @param     $id
     * @param int $roleId
     *
     * @return mixed
     */
    public function assignRole($id, int $roleId)
    {
        $user = $this->find($id);
        event(new RepositoryEntityUpdated($this, $user->assignRole($roleId)));
        return $user;
    }

    /**
     * @param     $id
     * @param int $permissionId
     */
    public function givePermissionTo($id, int $permissionId)
    {
        event(new RepositoryEntityUpdated($this, $this->find($id)->givePermissionTo($permissionId)));
    }

    /**
     * @param     $id
     * @param int $roleId
     */
    public function removeRole($id, int $roleId)
    {
        $user = $this->find($id);
        $user->removeRole($roleId);
        event(new RepositoryEntityUpdated($this, $user));
    }

    /**
     * @param     $id
     * @param int $permissionId
     */
    public function revokePermissionTo($id, int $permissionId)
    {
        $user = $this->find($id);
        $user->revokePermissionTo($permissionId);
        event(new RepositoryEntityUpdated($this, $user));
    }
}