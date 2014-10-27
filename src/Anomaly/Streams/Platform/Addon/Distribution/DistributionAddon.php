<?php namespace Anomaly\Streams\Platform\Addon\Distribution;

use Anomaly\Streams\Platform\Addon\Addon;
use Anomaly\Streams\Platform\Contract\PresentableInterface;

class DistributionAddon extends Addon implements PresentableInterface
{
    public function getAdminTheme()
    {
        return app('streams.theme.testable');
    }

    public function getPublicTheme()
    {
        return app('streams.theme.testable');
    }

    public function decorate()
    {
        return new DistributionPresenter($this);
    }
}
