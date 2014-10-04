<?php namespace Streams\Platform\Addon\Module\Event;

use Streams\Platform\Addon\Module\ModuleAbstract;

class ModuleWasUninstalledEvent
{
    /**
     * The module object.
     *
     * @var \Streams\Platform\Addon\Module\ModuleAbstract
     */
    protected $module;

    /**
     * Create a new ModuleWasUnnstalledEvent instance.
     *
     * @param ModuleAbstract $module
     */
    function __construct(ModuleAbstract $module)
    {
        $this->module = $module;
    }

    /**
     * Get the module object.
     *
     * @return mixed
     */
    public function getModule()
    {
        return $this->module;
    }
}
