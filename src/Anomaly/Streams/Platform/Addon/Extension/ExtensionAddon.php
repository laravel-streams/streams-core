<?php namespace Anomaly\Streams\Platform\Addon\Extension;

use Anomaly\Streams\Platform\Addon\Addon;
use Anomaly\Streams\Platform\Contract\PresentableInterface;

class ExtensionAddon extends Addon implements PresentableInterface
{
    public function newPresenter()
    {
        return new ExtensionPresenter($this);
    }
}
