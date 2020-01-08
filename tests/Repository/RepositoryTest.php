<?php
/**
 * Created by PhpStorm.
 * User: Lloric Mayuga Garcia <lloricode@gmail.com>
 * Date: 1/1/19
 * Time: 8:39 AM
 */

namespace Tests\Repository;

use Tests\TestCase;

class RepositoryTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->loggedInAs();
    }

    /**
     * @param  bool  $enableSkip
     * @param  int  $limitRequest
     * @param  int  $limitDefault
     * @param  int  $addRoleCount
     * @param  int  $expectedCount
     * @param  string|null  $queryParamLimit
     *
     * @test
     * @dataProvider paginateDataProvider()
     */
    public function paginationEnableSkipThenLimitZero(
        bool $enableSkip,
        int $limitRequest,
        int $limitDefault,
        int $addRoleCount,
        int $expectedCount,
        string $queryParamLimit = null
    ) {
        $queryParamLimit = is_null($queryParamLimit) ? '' : "?limit=$queryParamLimit";

        config(
            [
                'setting.repository.skip_pagination' => $enableSkip,
                'setting.repository.limit_pagination' => $limitRequest,
                'repository.pagination.limit' => $limitDefault,
            ]
        );

        $roleModel = app(config('permission.models.role'));
        $addRoleCount -= $roleModel::count();// exclude count seeded role

        foreach (range(1, $addRoleCount) as $i) {
            $roleModel::create(
                [
                    'name' => 'role test '.$i,
                ]
            );
        }

        $this->get($this->route('backend.roles.index').$queryParamLimit, $this->addHeaders());

        $content = ((array)json_decode($this->response->getContent()));

        $isContentHasData = isset($content['data']);

        $this->assertTrue($isContentHasData);

        if ($isContentHasData) {
            $this->assertCount($expectedCount, $content['data']);
        }
    }

    /**
     * @return array
     */
    public function paginateDataProvider()
    {
        /**
         * 1 bool $enableSkip,
         * 2 int $limitRequest,
         * 3 int $limitDefault,
         * 4 int $addRoleCount,
         * 5 int $expectedCount,
         * 6 string $queryParamLimit = null
         */
        return [
            'default behavior' => [true, 100, 15, 20, 15],
            'default behavior with disable skip' => [false, 100, 15, 20, 15],
            '.' => [true, 100, 15, 100, 50, '50'],
            '..' => [false, 100, 15, 20, 20, '100'],

            // request limit non numeric
            'request limit non numeric default behavior' => [true, 100, 15, 20, 15, 'ccc'],
            'request limit non numeric default behavior with disable skip' => [false, 100, 15, 20, 15, 'ccc'],

            // zero
            'zero request limit' => [true, 100, 15, 20, 20, '0'],
            'zero request limit with disable skip' => [false, 100, 15, 20, 15, '0'],

            // invalid request limit
            'negative request limit' => [true, 100, 20, 100, 20, '-1'],
            'exceed max request limit' => [true, 50, 20, 100, 20, '60'],
        ];
    }
}