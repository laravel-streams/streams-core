<?php namespace Streams\Platform\Addon\Extension;

use Streams\Platform\Addon\Addon;

class ExtensionAddon extends Addon
{
    public function newPresenter()
    {
        return new ExtensionPresenter($this);
    }

    public function newServiceProvider()
    {
        return new ExtensionServiceProvider($this->app);
    }
}
