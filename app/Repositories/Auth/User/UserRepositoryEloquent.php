<?php
/**
 * Created by PhpStorm.
 * User: Lloric Mayuga Garcia <lloricode@gmail.com>
 * Date: 11/24/18
 * Time: 3:23 PM
 */

namespace App\Repositories\Auth\User;

use App\Criterion\Eloquent\ThisEqualThatCriteria;
use App\Criterion\Eloquent\WithTrashCriteria;
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
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function findOrCreateProvider(\Laravel\Socialite\Two\User $data, string $provider): User
    {
        if ($user = $this->getFromSocialAccount($data->id, $provider)) {
            return $user;
        }

        // User email may not provided.
        $userEmail = $data->email ?: "{$data->id}@{$provider}.com";

        $this->pushCriteria(new WithTrashCriteria());
        $this->pushCriteria(new ThisEqualThatCriteria('email', $userEmail));

        /** @var User $user */
        $user = $this->all()->first();

        if (filled($user) && $user->trashed()) {
            abort(401, 'Invalid credentials');
        }

        $fresh = false;

        if (blank($user)) {
            // Get users first name and last name from their full name
            $nameParts = $this->getNameParts($data);

            $user = $this->create(
                [
                    'first_name' => $nameParts['first_name'],
                    'last_name' => $nameParts['last_name'],
                    'email' => $userEmail,
                    'avatar_type' => $provider,
                ]
            );
            $fresh = true;
        }

        $this->provider($user, $data, $provider);

        if ($fresh) {
            event(new Registered($user->refresh()));
        }

        return $user;
    }

    private function getFromSocialAccount(string $providerID, string $provider): ?User
    {
        return optional(
            SocialAccount::where(
                [
                    'provider' => $provider,
                    'provider_id' => $providerID,
                ]
            )->first()
        )->user;
    }

    /**
     * @param  \App\Models\Auth\User\User  $user
     * @param  \Laravel\Socialite\Two\User  $data
     * @param  string  $provider
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    private function provider(User $user, \Laravel\Socialite\Two\User $data, string $provider)
    {
        if ($user->hasProvider($provider, $data->id)) {
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
        } else {
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
        }
    }

    protected function getNameParts(\Laravel\Socialite\Two\User $data)
    {
        $result = [];

        $result['first_name'] = $data->offsetGet('first_name');
        $result['last_name'] = $data->offsetGet('last_name');
        return $result;
    }
}