<?php namespace Streams\Platform\Addon\Extension;

use Streams\Platform\Addon\AddonAbstract;

abstract class ExtensionAbstract extends AddonAbstract
{
    /**
     * Return a new ExtensionModel instance.
     *
     * @return null|ExtensionModel
     */
    public function newModel()
    {
        return new ExtensionModel();
    }

    /**
     * Return a new presenter instance.
     *
     * @param $resource
     * @return null|ExtensionPresenter
     */
    public function newPresenter($resource)
    {
        return new ExtensionPresenter($resource);
    }
}
