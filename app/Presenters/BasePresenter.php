<?php
/**
 * Created by PhpStorm.
 * User: Lloric Mayuga Garcia <lloricode@gmail.com>
 * Date: 12/23/18
 * Time: 10:47 AM
 */

namespace App\Presenters;

use League\Fractal\Resource\ResourceAbstract;
use Prettus\Repository\Presenter\FractalPresenter;

abstract class BasePresenter extends FractalPresenter
{
    /**
     * {@inheritdoc}
     */
    protected function transformItem($data)
    {
        return $this->addAvailableIncludeToMeta(parent::transformItem($data));
    }

    /**
     * @param \League\Fractal\Resource\ResourceAbstract $resource
     *
     * @return \League\Fractal\Resource\ResourceAbstract
     */
    private function addAvailableIncludeToMeta(ResourceAbstract $resource)
    {
        $resource->setMeta([
            'include' => $this->getTransformer()->getAvailableIncludes(),
        ]);
        return $resource;
    }

    /**
     * {@inheritdoc}
     */
    protected function transformCollection($data)
    {
        return $this->addAvailableIncludeToMeta(parent::transformCollection($data));
    }

    /**
     * {@inheritdoc}
     */
    protected function transformPaginator($paginator)
    {
        return $this->addAvailableIncludeToMeta(parent::transformPaginator($paginator));
    }
}