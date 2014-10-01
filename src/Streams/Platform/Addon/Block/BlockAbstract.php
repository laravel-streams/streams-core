<?php namespace Streams\Platform\Addon\Block;

use Streams\Platform\Addon\AddonAbstract;
use Streams\Platform\Addon\Model\BlockModel;
use Streams\Platform\Addon\Presenter\BlockPresenter;

abstract class BlockAbstract extends AddonAbstract
{
    /**
     * Return a new BlockModel instance.
     *
     * @return null|BlockModel
     */
    public function newModel()
    {
        return new BlockModel();
    }

    /**
     * Return a new presenter instance.
     *
     * @param $resource
     * @return null|BlockPresenter
     */
    public function newPresenter($resource)
    {
        return new BlockPresenter($resource);
    }
}
