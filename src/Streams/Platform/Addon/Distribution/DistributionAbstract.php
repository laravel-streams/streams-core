<?php namespace Streams\Platform\Addon\Distribution;

use Streams\Platform\Addon\AddonAbstract;
use Streams\Platform\Addon\Presenter\DistributionPresenter;

abstract class DistributionAbstract extends AddonAbstract
{
    /**
     * Return a new DistributionPresenter instance.
     *
     * @param $resource
     * @return null|DistributionPresenter
     */
    public function newPresenter($resource)
    {
        return new DistributionPresenter($resource);
    }
}
