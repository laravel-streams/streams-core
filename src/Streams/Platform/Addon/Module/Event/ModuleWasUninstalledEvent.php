<?php namespace Streams\Platform\Addon\Module\Event;

use Streams\Platform\Addon\Module\ModuleAddon;

class ModuleWasUninstalledEvent
{
    /**
     * The module object.


*
*@var \Streams\Platform\Addon\Module\ModuleAddon
     */
    protected $module;

    /**
     * Create a new ModuleWasUnnstalledEvent instance.


*
*@param ModuleAddon $module
     */
    function __construct(ModuleAddon $module)
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
