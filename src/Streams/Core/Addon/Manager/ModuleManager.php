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
     * Return the active module.
     *
     * @return \AddonAbstract
     */
    public function getActive()
    {
        $slug = \Request::segment(1) == 'admin' ? \Request::segment(2) : \Request::segment(1);

        if (!in_array(\Request::segment(2), ['login', 'logout']) and $this->exists($slug)) {
            return \Module::get($slug);
        }
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
