<?php
/**
 * Created by PhpStorm.
 * User: lloric
 * Date: 3/6/19
 * Time: 1:46 PM
 */

namespace App\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

interface BaseRepositoryInterface extends RepositoryInterface
{
    /**
     * @param $id
     *
     * @return mixed
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function restore($id);

    /**
     * @param int $id
     *
     * @return mixed
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function forceDelete(int $id);
}