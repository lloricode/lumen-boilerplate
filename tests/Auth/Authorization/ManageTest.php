<?php

declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: Lloric Mayuga Garcia <lloricode@gmail.com>
 * Date: 12/26/18
 * Time: 5:19 PM
 */

use Database\Factories\Auth\User\UserFactory;

use function PHPUnit\Framework\assertFalse;

uses(Test\Auth\Authorization\BaseRole::class);

beforeEach(fn () => $this->loggedInAs());

it('assign role to user', function () {
    $user = UserFactory::new()->create();
    $role = $this->createRole();
    $this->showModelWithRelation('auth/users/'.  self::forId($user), $role, 'roles', 'dontSeeJson');

    post(
        'auth/authorizations/assign-role-to-user?include=roles',
        [
            'role_id' => self::forId($role),
            'user_id' => self::forId($user),
        ],
        $this->addHeaders()
    );
    assertResponseOk();

    $this->showModelWithRelation('auth/users/'.  self::forId($user), $role, 'roles');
});

it('revoke role from user', function () {
    $user = UserFactory::new()->create();
    $role = $this->createRole();
    $user->assignRole($role);

//        $this->showModelWithRelation('backend.users.show', $user, $role, 'roles');

    delete(
        'auth/authorizations/revoke-role-from-user?include=roles',
        [
            'role_id' => self::forId($role),
            'user_id' => self::forId($user),
        ],
        $this->addHeaders()
    );
    assertResponseStatus(204);

    assertFalse($user->refresh()->hasRole($role));
//        $this->seeJsonApiRelation($role, 'roles', 'dontSeeJson');
//        $this->showModelWithRelation('backend.users.show', $user, $role, 'roles', 'dontSeeJson');
});

it('assign permission to user', function () {
    $user = UserFactory::new()->create();
    $permission = $this->createPermission();

    $this->showModelWithRelation('auth/users/'. self::forId($user), $permission, 'permissions', 'dontSeeJson');

    post(
        'auth/authorizations/assign-permission-to-user?include=permissions',
        [
            'permission_id' => self::forId($permission),
            'user_id' => self::forId($user),
        ],
        $this->addHeaders()
    );
    assertResponseOk();

    $this->showModelWithRelation('auth/users/'. self::forId($user), $permission, 'permissions');
});

it('revoke permission to user', function () {
    /** @var \App\Models\Auth\User\User $user */
    $user = UserFactory::new()->create();

    $permission = $this->createPermission();
    $user->givePermissionTo($permission);

//        $this->showModelWithRelation('backend.users.show', $user, $permission, 'permissions');

    delete(
        'auth/authorizations/revoke-permission-from-user?include=permissions',
        [
            'permission_id' => self::forId($permission),
            'user_id' => self::forId($user),
        ],
        $this->addHeaders()
    );
    assertResponseStatus(204);

    assertFalse($user->refresh()->hasPermissionTo($permission));
//        $this->seeJsonApiRelation($permission, 'permissions', 'dontSeeJson');
//        $this->showModelWithRelation('backend.users.show', $user, $permission, 'permissions', 'dontSeeJson');
});

it('attach permission to role', function () {
    $role = $this->createRole();
    $permission = $this->createPermission();

    $this->showModelWithRelation('auth/roles/'.self::forId($role), $permission, 'permissions', 'dontSeeJson');

    post(
        'auth/authorizations/attach-permission-to-role?include=permissions',
        [
            'permission_id' => self::forId($permission),
            'role_id' => self::forId($role),
        ],
        $this->addHeaders()
    );
    assertResponseOk();

    $this->showModelWithRelation('auth/roles/'.self::forId($role), $permission, 'permissions');
});

it('revoke permission from role', function () {
    $role = $this->createRole();
    $permission = $this->createPermission();
    $role->givePermissionTo($permission);

//        $this->showModelWithRelation('backend.roles.show', $role, $permission, 'permissions');

    delete(
        'auth/authorizations/revoke-permission-from-role?include=permissions',
        [
            'permission_id' => self::forId($permission),
            'role_id' => self::forId($role),
        ],
        $this->addHeaders()
    );
    assertResponseStatus(204);

    assertFalse($role->refresh()->hasPermissionTo($permission));
//        $this->seeJsonApiRelation($permission, 'permissions', 'dontSeeJson');
//        $this->showModelWithRelation('backend.roles.show', $role, $permission, 'permissions', 'dontSeeJson');
});
