<?php

declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: Lloric Mayuga Garcia <lloricode@gmail.com>
 * Date: 11/24/18
 * Time: 3:31 PM
 */

namespace App\Transformers\Auth;

use App\Models\Auth\User\User;
use App\Transformers\BaseTransformer;

/**
 * @OA\Schema(
 *     schema="UserTransformer",
 *     type="object",
 *     properties={
 *         @OA\Property(property="id", type="string"),
 *         @OA\Property(property="attributes", type="object", properties={
 *
 *             @OA\Property(property="first_name", type="string"),
 *             @OA\Property(property="last_name", type="string"),
 *             @OA\Property(property="email", type="string"),
 *             @OA\Property(property="created_at", type="string"),
 *             @OA\Property(property="created_at_readable", type="string"),
 *             @OA\Property(property="updated_at", type="string"),
 *             @OA\Property(property="updated_at_readable", type="string")
 *
 *         }),
 *         @OA\Property(property="relationships", type="array", @OA\Items({
 *
 *         })),
 *         @OA\Property(property="meta", type="array", @OA\Items({
 *
 *             @OA\Property(property="include", type="array", @OA\Items({
 *             })),
 *         })),
 *     }
 * )
 */
class UserTransformer extends BaseTransformer
{
    protected array $availableIncludes = [
        'roles',
        'permissions',
    ];

    /**
     * A Fractal transformer.
     *
     * @param  \App\Models\Auth\User\User  $user
     *
     * @return array
     */
    public function transform(User $user)
    {
        $response = [
            'id' => self::forId($user),
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'email' => $user->email,
        ];

        $response = $this->filterData(
            $response,
            [

            ]
        );

        return $this->addTimesHumanReadable($user, $response);
    }

    public function includeRoles(User $user)
    {
        return $this->collection($user->roles, new RoleTransformer());
    }

    public function includePermissions(User $user)
    {
        return $this->collection($user->permissions, new PermissionTransformer());
    }

    /** @return string */
    public function getResourceKey(): string
    {
        return 'users';
    }
}
