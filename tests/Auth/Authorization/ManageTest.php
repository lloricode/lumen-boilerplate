<?php
/**
 * Created by PhpStorm.
 * User: Lloric Mayuga Garcia <lloricode@gmail.com>
 * Date: 12/26/18
 * Time: 5:19 PM
 */

namespace Test\Auth\Authorization;

use Database\Factories\Auth\User\UserFactory;

class ManageTest extends BaseRole
{
    public function setUp(): void
    {
        parent::setUp();
        $this->loggedInAs();
    }

    /** @test */
    public function assign_role_to_user()
    {
        $user = UserFactory::new()->create();
        $role = $this->createRole();

        $this->showModelWithRelation('backend.users.show', $user, $role, 'roles', 'dontSeeJson');

        $this->post(
            route('backend.authorizations.assign-role-to-user').'?include=roles',
            [
                'role_id' => self::forId($role),
                'user_id' => self::forId($user),
            ],
            $this->addHeaders()
        );
        $this->assertResponseOk();

        $this->showModelWithRelation('backend.users.show', $user, $role, 'roles');
    }

    /** @test */
    public function revoke_role_from_user()
    {
        $user = UserFactory::new()->create();
        $role = $this->createRole();
        $user->assignRole($role);

//        $this->showModelWithRelation('backend.users.show', $user, $role, 'roles');

        $this->delete(
            route('backend.authorizations.revoke-role-from-user').'?include=roles',
            [
                'role_id' => self::forId($role),
                'user_id' => self::forId($user),
            ],
            $this->addHeaders()
        );
        $this->assertResponseStatus(204);

        $this->assertFalse($user->refresh()->hasRole($role));
//        $this->seeJsonApiRelation($role, 'roles', 'dontSeeJson');
//        $this->showModelWithRelation('backend.users.show', $user, $role, 'roles', 'dontSeeJson');
    }

    /** @test */
    public function assign_permission_to_user()
    {
        $user = UserFactory::new()->create();
        $permission = $this->createPermission();

        $this->showModelWithRelation('backend.users.show', $user, $permission, 'permissions', 'dontSeeJson');

        $this->post(
            route('backend.authorizations.assign-permission-to-user').'?include=permissions',
            [
                'permission_id' => self::forId($permission),
                'user_id' => self::forId($user),
            ],
            $this->addHeaders()
        );
        $this->assertResponseOk();

        $this->showModelWithRelation('backend.users.show', $user, $permission, 'permissions');
    }

    /** @test */
    public function revoke_permission_to_user()
    {
        $user = UserFactory::new()->create();

        $permission = $this->createPermission();
        $user->givePermissionTo($permission);

//        $this->showModelWithRelation('backend.users.show', $user, $permission, 'permissions');

        $this->delete(
            route('backend.authorizations.revoke-permission-from-user').'?include=permissions',
            [
                'permission_id' => self::forId($permission),
                'user_id' => self::forId($user),
            ],
            $this->addHeaders()
        );
        $this->assertResponseStatus(204);

        $this->assertFalse($user->refresh()->hasPermissionTo($permission));
//        $this->seeJsonApiRelation($permission, 'permissions', 'dontSeeJson');
//        $this->showModelWithRelation('backend.users.show', $user, $permission, 'permissions', 'dontSeeJson');
    }

    /** @test */
    public function attach_permission_to_role()
    {
        $role = $this->createRole();
        $permission = $this->createPermission();

        $this->showModelWithRelation('backend.roles.show', $role, $permission, 'permissions', 'dontSeeJson');

        $this->post(
            route('backend.authorizations.attach-permission-to-role').'?include=permissions',
            [
                'permission_id' => self::forId($permission),
                'role_id' => self::forId($role),
            ],
            $this->addHeaders()
        );
        $this->assertResponseOk();

        $this->showModelWithRelation('backend.roles.show', $role, $permission, 'permissions');
    }

    /** @test */
    public function revoke_permission_from_role()
    {
        $role = $this->createRole();
        $permission = $this->createPermission();
        $role->givePermissionTo($permission);

//        $this->showModelWithRelation('backend.roles.show', $role, $permission, 'permissions');

        $this->delete(
            route('backend.authorizations.revoke-permission-from-role').'?include=permissions',
            [
                'permission_id' => self::forId($permission),
                'role_id' => self::forId($role),
            ],
            $this->addHeaders()
        );
        $this->assertResponseStatus(204);

        $this->assertFalse($role->refresh()->hasPermissionTo($permission));
//        $this->seeJsonApiRelation($permission, 'permissions', 'dontSeeJson');
//        $this->showModelWithRelation('backend.roles.show', $role, $permission, 'permissions', 'dontSeeJson');
    }
}