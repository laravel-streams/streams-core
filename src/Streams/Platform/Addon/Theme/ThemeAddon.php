<?php namespace Streams\Platform\Addon\Theme;

use Streams\Platform\Addon\Addon;

class ThemeAddon extends Addon
{
    protected $admin = false;

    public function isAdmin()
    {
        return $this->admin;
    }

    public function newTag()
    {
        return new ThemeTag($this->app);
    }

    public function newPresenter()
    {
        return new ThemePresenter($this);
    }

    public function newServiceProvider()
    {
        return new ThemeServiceProvider($this->app);
    }
}
