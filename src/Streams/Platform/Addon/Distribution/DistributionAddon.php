<?php namespace Streams\Platform\Addon\Distribution;

use Streams\Platform\Addon\Addon;

class DistributionAddon extends Addon
{
    protected $type = 'distribution';

    public function getAdminTheme()
    {
        return 'streams';
    }

    public function getPublicTheme()
    {
        return 'streams';
    }

    public function newPresenter()
    {
        return new DistributionPresenter($this);
    }

    public function newServiceProvider()
    {
        return new DistributionServiceProvider($this->app);
    }
}
