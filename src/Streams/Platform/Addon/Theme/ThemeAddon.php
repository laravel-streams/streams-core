<?php namespace Streams\Platform\Addon\Theme;

use Streams\Platform\Addon\Addon;

class ThemeAddon extends Addon
{
    /**
     * Is this an admin theme?
     *
     * @var bool
     */
    protected $admin = false;

    /**
     * Return whether this theme is admin or not.
     *
     * @return bool
     */
    public function isAdmin()
    {
        return $this->admin;
    }

    /**
     * Return a new ThemeModel instance.
     *
     * @return null|ThemeModel
     */
    public function newModel()
    {
        return new ThemeModel();
    }

    public function newTag()
    {
        $tag = get_called_class() . 'Tag';

        if (class_exists($tag)) {
            return new $tag;
        }

        return null;
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
