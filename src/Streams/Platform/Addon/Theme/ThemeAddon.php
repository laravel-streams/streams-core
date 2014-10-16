<?php namespace Streams\Platform\Addon\Theme;

use Streams\Platform\Addon\Addon;

class ThemeAddon extends Addon
{
    protected $type = 'theme';

    protected $admin = false;

    protected $active = false;

    public function isAdmin()
    {
        return $this->admin;
    }

    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    public function isActive()
    {
        return $this->active;
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
