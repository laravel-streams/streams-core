<?php namespace Streams\Core\Addon\Manager;

use Streams\Core\Addon\Model\ModuleModel;
use Streams\Core\Addon\Collection\ModuleCollection;

class ModuleManager extends AddonManager
{
    /**
     * The folder within addons locations to load modules from.
     *
     * @var string
     */
    protected $folder = 'modules';

    /**
     * The slug of the currently active module.
     *
     * @var null
     */
    protected $active = null;

    /**
     * Return the active module.
     *
     * @return null|\Streams\Core\Addon\AddonAbstract
     */
    public function active()
    {
        if ($this->exists($this->active)) {
            return $this->find($this->active);
        }

        return null;
    }

    /**
     * Get the active module slug.
     *
     * @return null
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Set the active module slug.
     *
     * @param $slug
     * @return $this
     */
    public function setActive($slug)
    {
        $this->active = $slug;

        return $this;
    }

    /**
     * Return a new model instance.
     *
     * @return mixed
     */
    protected function newModel()
    {
        return new ModuleModel();
    }

    /**
     * Return a new collection instance.
     *
     * @param array $modules
     * @return null|ModuleCollection
     */
    protected function newCollection(array $modules = [])
    {
        return new ModuleCollection($modules);
    }
}
