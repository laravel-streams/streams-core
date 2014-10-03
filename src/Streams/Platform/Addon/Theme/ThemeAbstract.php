<?php namespace Streams\Platform\Addon\Theme;

use Streams\Platform\Addon\AddonAbstract;

abstract class ThemeAbstract extends AddonAbstract
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

    /**
     * Return a new ThemeTag instance.
     *
     * @return ThemeTag
     */
    public function newTag()
    {
        $tag = get_called_class() . 'Tag';

        if (class_exists($tag)) {
            return new $tag;
        }

        return new ThemeTag();
    }
}
