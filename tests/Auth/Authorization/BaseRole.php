<?php
/**
 * Created by PhpStorm.
 * User: Lloric Mayuga Garcia <lloricode@gmail.com>
 * Date: 12/24/18
 * Time: 11:30 AM
 */

namespace Tests\Auth\Authorization;

use App\Models\Auth\Permission\Permission;
use App\Models\Auth\Role\Role;
use Illuminate\Database\Eloquent\Model;
use Tests\TestCase;


abstract class BaseRole extends TestCase
{
    /**
     * checking multiple time, to make sure caching is properly manage.
     *
     * @param  string  $routeName
     * @param  \Illuminate\Database\Eloquent\Model  $modelShow
     * @param  \Illuminate\Database\Eloquent\Model  $modelRelation
     * @param  string  $relation
     * @param  string  $assert
     */
    protected function showModelWithRelation(
        string $routeName,
        Model $modelShow,
        Model $modelRelation,
        string $relation,
        string $assert = 'seeJson'
    )
    {
        $this->get(
            $this->route(
                $routeName,
                [
                    'id' => $modelShow->getHashedId(),
                ]
            )."?include=$relation",
            $this->addHeaders()
        );
        $this->assertResponseOk();

        $this->seeJsonApiRelation($modelRelation, $relation, $assert);
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Model  $modelRelation
     * @param  string  $relation
     * @param  string  $assert
     *
     * @return mixed
     */
    protected function seeJsonApiRelation(Model $modelRelation, string $relation, string $assert = 'seeJson')
    {
        return $this->{$assert}(
            [
                'relationships' => [
                    $relation => [
                        'data' => [
                            [
                                'type' => $relation,
                                'id' => $modelRelation->getHashedId(),
                            ]
                        ]
                    ]
                ]
            ]
        );
    }

    protected function getByRoleName(string $accessRoleName = 'system'): Role
    {
        return app(config('permission.models.role'))
            ->findByName(config("setting.permission.role_names.$accessRoleName"));
    }

    protected function replaceRoleUri($uri, Role $role = null): string
    {
        $role = is_null($role) ? app(config('permission.models.role'))->first() : $role;

        return str_replace('{id}', $role->getHashedId(), $uri);
    }

    protected function createRole($name = 'test role name'): Role
    {
        return app(config('permission.models.role'))::create(
            [
                'name' => $name,
            ]
        );
    }

    protected function createPermission($name = 'test permission name'): Permission
    {
        return app(config('permission.models.permission'))::create(
            [
                'name' => $name,
            ]
        );
    }

}