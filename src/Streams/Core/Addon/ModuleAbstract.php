<?php namespace Streams\Core\Addon;

use Streams\Core\Addon\Model\ModuleModel;
use Streams\Core\Addon\Presenter\ModulePresenter;

abstract class ModuleAbstract extends AddonAbstract
{
    /**
     * An array of module sections.
     *
     * @var null
     */
    protected $sections = null;

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
}
