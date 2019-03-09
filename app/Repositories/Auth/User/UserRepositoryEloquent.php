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
use Prettus\Validator\Contracts\ValidatorInterface;

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
     * Specify Validator Rules
     *
     * @var array
     */
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
        ],
        ValidatorInterface::RULE_UPDATE => [
            'first_name' => 'string',
            'last_name' => 'string',
            'email' => 'email|unique:users,email',
        ]
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
     * Save a new entity in repository
     *
     * @param array $attributes
     *
     * @return mixed
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function create(array $attributes)
    {
        $attributes['password'] = app('hash')->make($attributes['password']);

        return parent::create($attributes);
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