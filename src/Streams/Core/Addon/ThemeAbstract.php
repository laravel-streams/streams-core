<?php namespace Streams\Core\Addon;

use Streams\Core\Addon\Model\ThemeModel;
use Streams\Core\Addon\Presenter\ThemePresenter;

abstract class ThemeAbstract extends AddonAbstract
{
    /**
     * By default this is not an admin theme.
     *
     * @var bool
     */
    protected $admin = null;

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

    /**
     * Return a new presenter instance.
     *
     * @param $resource
     * @return null|ThemePresenter
     */
    public function newPresenter($resource)
    {
        return new ThemePresenter($resource);
    }
}
