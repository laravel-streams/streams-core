<?php namespace Streams\Platform\Addon\Module\Event;

use Streams\Platform\Addon\Module\Module;

class ModuleWasInstalledEvent
{
    /**
     * The module object.

     *
*@var \Streams\Platform\Addon\Module\Module
     */
    protected $module;

    /**
     * Create a new ModuleWasInstalledEvent instance.

     *
*@param Module $module
     */
    function __construct(Module $module)
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
