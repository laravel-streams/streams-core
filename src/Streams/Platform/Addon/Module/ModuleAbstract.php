<?php namespace Streams\Platform\Addon\Module;

use Streams\Platform\Addon\AddonAbstract;

abstract class ModuleAbstract extends AddonAbstract
{
    /**
     * The group string.
     *
     * @var null
     */
    protected $group = null;

    /**
     * The module menu.
     *
     * @var array
     */
    protected $menu = [];

    /**
     * An array of module sections.
     *
     * @var array
     */
    protected $sections = [];

    /**
     * Get the group string.
     *
     * @return null
     */
    public function getGroup()
    {
        return $this->group;
    }

    /**
     * Get the module menu.
     *
     * @return null
     */
    public function getMenu()
    {
        return $this->menu;
    }

    /**
     * Get the module sections.
     *
     * @return null
     */
    public function getSections()
    {
        return $this->sections;
    }

    /**
     * Return whether the module is active or not.
     *
     * @return bool
     */
    public function isActive()
    {
        return ($this->slug == app('streams.modules')->getActive());
    }

    /**
     * Return a new ModuleModel instance.
     *
     * @return null|ModuleModel
     */
    public function newModel()
    {
        return new ModuleModel();
    }
}
