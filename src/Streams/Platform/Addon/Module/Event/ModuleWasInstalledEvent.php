<?php namespace Streams\Platform\Addon\Module\Event;

use Streams\Platform\Addon\Module\ModuleAddon;

class ModuleWasInstalledEvent
{
    protected $module;

    function __construct($module)
    {
        $this->module = $module;
    }

    public function getModule()
    {
        return $this->module;
    }
}
