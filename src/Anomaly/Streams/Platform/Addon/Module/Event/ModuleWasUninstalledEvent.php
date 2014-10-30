<?php namespace Anomaly\Streams\Platform\Addon\Module\Event;

class ModuleWasUninstalledEvent
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
