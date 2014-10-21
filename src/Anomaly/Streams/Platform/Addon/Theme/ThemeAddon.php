<?php namespace Anomaly\Streams\Platform\Addon\Theme;

use Anomaly\Streams\Platform\Addon\Addon;
use Anomaly\Streams\Platform\Contract\PresentableInterface;

class ThemeAddon extends Addon implements PresentableInterface
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
}
