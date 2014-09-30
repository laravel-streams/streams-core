<?php namespace Streams\Platform\Addon;

use Streams\Platform\Addon\Tag\ModuleTag;
use Streams\Platform\Addon\Model\ModuleModel;
use Streams\Platform\Addon\Presenter\ModulePresenter;
use Streams\Platform\Addon\Provider\ModuleServiceProvider;

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

    /**
     * Return a new presenter instance.
     *
     * @param $resource
     * @return null|ModulePresenter
     */
    public function newPresenter($resource)
    {
        return new ModulePresenter($resource);
    }

    /**
     * Return a new ModuleTag instance.
     *
     * @return ModuleTag
     */
    public function newTag()
    {
        $tag = get_called_class() . 'Tag';

        if (class_exists($tag)) {
            return new $tag;
        }

        return new ModuleTag();
    }
}
