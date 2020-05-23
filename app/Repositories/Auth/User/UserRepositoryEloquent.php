<?php
/**
 * Created by PhpStorm.
 * User: Lloric Mayuga Garcia <lloricode@gmail.com>
 * Date: 11/24/18
 * Time: 3:23 PM
 */

namespace App\Repositories\Auth\User;

use App\Models\Auth\User\SocialAccount;
use App\Models\Auth\User\User;
use App\Repositories\BaseRepository;
use Illuminate\Auth\Events\Registered;
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
     * @param  int  $roleId
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
     * @param  int  $permissionId
     */
    public function givePermissionTo($id, int $permissionId)
    {
        event(new RepositoryEntityUpdated($this, $this->find($id)->givePermissionTo($permissionId)));
    }

    /**
     * @param     $id
     * @param  int  $roleId
     */
    public function removeRole($id, int $roleId)
    {
        $user = $this->find($id);
        $user->removeRole($roleId);
        event(new RepositoryEntityUpdated($this, $user));
    }

    /**
     * @param     $id
     * @param  int  $permissionId
     */
    public function revokePermissionTo($id, int $permissionId)
    {
        $user = $this->find($id);
        $user->revokePermissionTo($permissionId);
        event(new RepositoryEntityUpdated($this, $user));
    }

    /**
     * @param  \Laravel\Socialite\Two\User  $data
     * @param  string  $provider
     *
     * @return \App\Models\Auth\User\User
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function findOrCreateProvider(\Laravel\Socialite\Two\User $data, string $provider): User
    {
        // User email may not provided.
        $userEmail = $data->email ?: "{$data->id}@{$provider}.com";

        /** @var User $user */
        $user = $this->findWhere(['email' => $userEmail])->first();

        if (blank($user)) {
            // Get users first name and last name from their full name
            $nameParts = $this->getNameParts($data->getName());

            $user = $this->create(
                [
                    'first_name' => $nameParts['first_name'],
                    'last_name' => $nameParts['last_name'],
                    'email' => $userEmail,
                    'avatar_type' => $provider,
                ]
            );

            event(new Registered($user));
        }

        if (!$user->hasProvider($provider)) {
            $user->socialAccounts()->save(
                new SocialAccount(
                    [
                        'provider' => $provider,
                        'provider_id' => $data->id,
                        'token' => $data->token,
                        'avatar' => $data->avatar,
                    ]
                )
            );
        } else {
            // Update the users information, token and avatar can be updated.
            $user->socialAccounts()->update(
                [
                    'token' => $data->token,
                    'avatar' => $data->avatar,
                ]
            );


            $this->update(
                [
                    'avatar_type' => $provider,
                ],
                $user->id
            );
        }

        return $user;
    }

    private function getNameParts($fullName)
    {
        $parts = array_values(array_filter(explode(' ', $fullName)));
        $size = count($parts);
        $result = [];

        if (empty($parts)) {
            $result['first_name'] = null;
            $result['last_name'] = null;
        }

        if (!empty($parts) && $size == 1) {
            $result['first_name'] = $parts[0];
            $result['last_name'] = null;
        }

        if (!empty($parts) && $size >= 2) {
            $result['first_name'] = $parts[0];
            $result['last_name'] = $parts[1];
        }

        return $result;
    }
}