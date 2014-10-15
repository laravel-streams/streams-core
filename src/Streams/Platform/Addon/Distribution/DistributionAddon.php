<?php namespace Streams\Platform\Addon\Distribution;

use Streams\Platform\Addon\Addon;

class DistributionAddon extends Addon
{
    protected $type = 'distribution';

    public function getAdminTheme()
    {
        // Return the instantiated admin theme.
    }

    public function getPublicTheme()
    {
        // Return the instantiated public theme.
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
