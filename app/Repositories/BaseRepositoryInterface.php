<?php
/**
 * Created by PhpStorm.
 * User: lloric
 * Date: 3/6/19
 * Time: 1:46 PM
 */

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface BaseRepositoryInterface
 *
 * @package App\Repositories
 * @method \Prettus\Repository\Eloquent\BaseRepository pushCriteria(CriteriaInterface $param)
 * @method Model makeModel()
 * @method model()
 */
interface BaseRepositoryInterface extends RepositoryInterface
{
    public function getRouteKeyName(): string;

    public function findByRouteKeyName(string $key): ?Model;

    public function restore($id);

    public function forceDelete(int $id);
}
