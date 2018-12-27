<?php
/**
 * Created by PhpStorm.
 * User: Lloric Mayuga Garcia <lloricode@gmail.com>
 * Date: 12/23/18
 * Time: 9:49 AM
 */

namespace App\Presenters\Auth;

use App\Presenters\BasePresenter;
use App\Presenters\Transformers\Auth\PermissionTransformer;

class PermissionPresenter extends BasePresenter
{

    public function __construct()
    {
        parent::__construct();
        $this->resourceKeyItem =
        $this->resourceKeyCollection = 'permissions';
    }

    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new PermissionTransformer;
    }
}