<?php namespace Streams\Platform\Addon\Extension;

use Streams\Platform\Addon\Addon;

class ExtensionAddon extends Addon
{
    protected $type = 'extension';

    public function newPresenter()
    {
        return new ExtensionPresenter($this);
    }

    public function newServiceProvider()
    {
        return new ExtensionServiceProvider($this->app);
    }
}
