<?php
/**
 * Created by PhpStorm.
 * User: Lloric Mayuga Garcia <lloricode@gmail.com>
 * Date: 12/2/18
 * Time: 4:27 PM
 */

namespace App\Traits;

use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

/**
 * Trait Hashable
 *
 * @package App\Traits
 * @deprecated
 */
trait Hashable
{
    /**
     * @param  string  $hash
     *
     * @return mixed
     */
    public function decodeHash(string $hash)
    {
        $decoded = app('hashids')->decode($hash);

        if (empty($decoded)) {
            throw new BadRequestHttpException('Invalid hashed id.');
        }

        return $decoded[0];
    }

    /**
     * @param  string  $key
     *
     * @return string
     */
    public function getHashedId(string $key = 'id')
    {
        return app('hashids')->encode($this->{$key});
    }
}