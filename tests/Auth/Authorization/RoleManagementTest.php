<?php
/**
 * Created by PhpStorm.
 * User: Lloric Mayuga Garcia <lloricode@gmail.com>
 * Date: 12/24/18
 * Time: 11:17 AM
 */

namespace Test\Auth\Authorization;

class RoleManagementTest extends BaseRole
{
    /**
     * @param $routeName
     *
     * @test
     * @testWith ["store"]
     *          ["update"]
     */
    public function validation_role($routeName)
    {
        $this->loggedInAs();

        $route = "backend.roles.$routeName";
        $paramNoData = [
            'name' => '',
        ];
        switch ($routeName) {
            case 'store':
                $this->post(route($route), $paramNoData, $this->addHeaders());
                break;
            case 'update':
                $this->put(
                    route(
                        $route,
                        [
                            'id' => self::forId($this->createRole()),
                        ]
                    ),
                    $paramNoData,
                    $this->addHeaders()
                );
                break;
        }
        $this->assertResponseStatus(422);
        $this->seeJson(
            [
                'name' => ['The name field is required.'],
            ]
        );
    }

    /**
     * @param $verbMethod
     * @param $routeName
     *
     * @test
     * @testWith ["delete", "backend.roles.destroy"]
     *          ["put", "backend.roles.update"]
     */
    public function default_role_not_allowed($verbMethod, $routeName)
    {
        $this->loggedInAs();
        $this->{$verbMethod}(
            route(
                $routeName,
                [
                    'id' => self::forId($this->getByRoleName('system')),
                ]
            ),
            $verbMethod == 'delete' ? [] : ['name' => $this->getByRoleName('system')->name],
            $this->addHeaders()
        );
        $this->assertResponseStatus(403);
        $this->seeJson(
            [
                'message' => 'You cannot update/delete default role.',
            ]
        );
    }

    /**
     * @test
     */
    public function store_role_success()
    {
        $this->loggedInAs();

        $data = [
            'name' => 'test new role',
        ];
        $this->post(route('backend.roles.store'), $data, $this->addHeaders());

        $this->assertResponseStatus(201);
        $this->seeJson($data);
    }

    /**
     * @test
     */
    public function update_role_success()
    {
        $this->loggedInAs();
        $roleNameTest = 'im role name';

        $role = $this->createRole($roleNameTest);

        $data = [
            'name' => $roleNameTest.' new',
        ];

        $this->put(
            route(
                'backend.roles.update',
                [
                    'id' => self::forId($role),
                ]
            ),
            $data,
            $this->addHeaders()
        );

        $this->assertResponseStatus(200);
        $this->seeJson($data);
    }

    /**
     * @test
     */
    public function updateDuplicateRole()
    {
        $this->loggedInAs();
        $duplicateNameTest = 'im duplicate role name';

        $this->createRole($duplicateNameTest);

        $role = $this->createRole('another role name');

        $data = [
            'name' => $duplicateNameTest,
        ];

        $this->put(
            route(
                'backend.roles.update',
                [
                    'id' => self::forId($role),
                ]
            ),
            $data,
            $this->addHeaders()
        );

        $this->assertResponseStatus(422);
        $this->seeJson(
            [
                'message' => "A role `{$duplicateNameTest}` already exists for guard `api`.",
            ]
        );
    }

    /**
     * @test
     */
    public function storeDuplicateRole()
    {
        $this->loggedInAs();
        $roleNameTest = 'im duplicate role name';

        $this->createRole($roleNameTest);

        $data = [
            'name' => $roleNameTest,
        ];
        $this->post(route('backend.roles.store'), $data, $this->addHeaders());

        $this->assertResponseStatus(422);
        $this->seeJson(
            [
                'message' => "A role `$roleNameTest` already exists for guard `api`.",
            ]
        );
    }
}