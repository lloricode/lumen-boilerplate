<?php
/**
 * Created by PhpStorm.
 * User: Lloric Mayuga Garcia <lloricode@gmail.com>
 * Date: 12/2/18
 * Time: 4:27 PM
 */

namespace App\Traits;

use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

trait Hashable
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param string                   $keyColumn
     *
     * @return mixed
     */
    public function decodeId(Request $request, string $keyColumn = 'id')
    {
        // https://github.com/laravel/lumen-framework/issues/685#issuecomment-350376018
        // https://github.com/laravel/lumen-framework/issues/685#issuecomment-443393222
        return $this->decodeHash($request->route()[2][$keyColumn]);
    }

    /**
     * @param string $hash
     *
     * @return mixed
     */
    public function decodeHash(string $hash)
    {
        $keyColumnValue = app('hashids')->decode($hash);

        if (empty($keyColumnValue)) {
            throw new NotFoundHttpException('Invalid hashed id.');
        }

        return $keyColumnValue[0];
    }

    /**
     * @param string $key
     *
     * @return string
     */
    public function getHashedId(string $key = 'id')
    {
        return app('hashids')->encode($this->{$key});
    }
}