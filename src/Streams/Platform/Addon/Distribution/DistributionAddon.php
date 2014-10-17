<?php namespace Streams\Platform\Addon\Distribution;

use Streams\Platform\Addon\Addon;

class DistributionAddon extends Addon
{
    protected $type = 'distribution';

    public function getAdminTheme()
    {
        return app('streams.theme.testable');
    }

    public function getPublicTheme()
    {
        return app('streams.theme.testable');
    }

    public function newPresenter()
    {
        return new DistributionPresenter($this);
    }
}
