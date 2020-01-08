<?php
/**
 * Created by PhpStorm.
 * User: Lloric Mayuga Garcia <lloricode@gmail.com>
 * Date: 12/26/18
 * Time: 5:19 PM
 */

namespace Tests\Auth\Authorization;

use App\Models\Auth\User\User;

class ManageTest extends BaseRole
{
    public function setUp(): void
    {
        parent::setUp();
        $this->loggedInAs();
    }

    /**
     * @test
     */
    public function assignRoleToUser()
    {
        $user = factory(User::class)->create();
        $role = $this->createRole();

        // TODO: check data first
        // $this->showModelWithRelation('backend.users.show', $user, $role, 'roles', 'dontSeeJson');

        $this->post(
            $this->route('backend.authorizations.assign-role-to-user').'?include=roles',
            [
                'role_id' => $role->getHashedId(),
                'user_id' => $user->getHashedId(),
            ],
            $this->addHeaders()
        );
        $this->assertResponseOk();

        // temporary
        // https://github.com/dingo/api/issues/1609
        $this->seeJsonApiRelation($role, 'roles');


        // TODO: check data after
//        $this->showModelWithRelation('backend.users.show', $user, $role, 'roles');
    }

    /**
     * @test
     */
    public function revokeRoleFromUser()
    {
        $user = factory(User::class)->create();
        $role = $this->createRole();
        $user->assignRole($role);

//        $this->showModelWithRelation('backend.users.show', $user, $role, 'roles');

        $this->post(
            $this->route('backend.authorizations.revoke-role-from-user').'?include=roles',
            [
                'role_id' => $role->getHashedId(),
                'user_id' => $user->getHashedId(),
            ],
            $this->addHeaders()
        );
        $this->assertResponseOk();

        $this->seeJsonApiRelation($role, 'roles', 'dontSeeJson');
//        $this->showModelWithRelation('backend.users.show', $user, $role, 'roles', 'dontSeeJson');
    }

    /**
     * @test
     */
    public function assignPermissionToUser()
    {
        $user = factory(User::class)->create();
        $permission = $this->createPermission();

        // TODO: check data first
        // $this->showModelWithRelation('backend.users.show', $user, $permission, 'permissions', 'dontSeeJson');

        $this->post(
            $this->route('backend.authorizations.assign-permission-to-user').'?include=permissions',
            [
                'permission_id' => $permission->getHashedId(),
                'user_id' => $user->getHashedId(),
            ],
            $this->addHeaders()
        );
        $this->assertResponseOk();

        // temporary
        // https://github.com/dingo/api/issues/1609
        $this->seeJsonApiRelation($permission, 'permissions');


        // TODO: check data after
//        $this->showModelWithRelation('backend.users.show', $user, $permission, 'permissions');
    }

    /**
     * @test
     */
    public function revokePermissionToUser()
    {
        $user = factory(User::class)->create();

        $permission = $this->createPermission();
        $user->givePermissionTo($permission);

//        $this->showModelWithRelation('backend.users.show', $user, $permission, 'permissions');

        $this->post(
            $this->route('backend.authorizations.revoke-permission-from-user').'?include=permissions',
            [
                'permission_id' => $permission->getHashedId(),
                'user_id' => $user->getHashedId(),
            ],
            $this->addHeaders()
        );
        $this->assertResponseOk();

        $this->seeJsonApiRelation($permission, 'permissions', 'dontSeeJson');
//        $this->showModelWithRelation('backend.users.show', $user, $permission, 'permissions', 'dontSeeJson');
    }

    /**
     * @test
     */
    public function attachPermissionToRole()
    {
        $role = $this->createRole();
        $permission = $this->createPermission();

        // TODO: check data first
        // $this->showModelWithRelation('backend.roles.show', $role, $permission, 'permissions', 'dontSeeJson');

        $this->post(
            $this->route('backend.authorizations.attach-permission-to-role').'?include=permissions',
            [
                'permission_id' => $permission->getHashedId(),
                'role_id' => $role->getHashedId(),
            ],
            $this->addHeaders()
        );
        $this->assertResponseOk();

        // temporary
        // https://github.com/dingo/api/issues/1609
        $this->seeJsonApiRelation($permission, 'permissions');

        // TODO: check data after
//        $this->showModelWithRelation('backend.roles.show', $role, $permission, 'permissions');
    }

    /**
     * @test
     */
    public function revokePermissionFromRole()
    {
        $role = $this->createRole();
        $permission = $this->createPermission();
        $role->givePermissionTo($permission);

//        $this->showModelWithRelation('backend.roles.show', $role, $permission, 'permissions');

        $this->post(
            $this->route('backend.authorizations.revoke-permission-from-role').'?include=permissions',
            [
                'permission_id' => $permission->getHashedId(),
                'role_id' => $role->getHashedId(),
            ],
            $this->addHeaders()
        );
        $this->assertResponseOk();

        $this->seeJsonApiRelation($permission, 'permissions', 'dontSeeJson');
//        $this->showModelWithRelation('backend.roles.show', $role, $permission, 'permissions', 'dontSeeJson');
    }
}