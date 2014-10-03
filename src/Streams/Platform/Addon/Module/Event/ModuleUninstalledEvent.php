<?php namespace Streams\Platform\Addon\Module\Event;

class ModuleUninstalledEvent
{
    /**
     * The uninstalled module.
     *
     * @var
     */
    protected $module;

    /**
     * Create a new ModuleUninstalledEvent instance.
     *
     * @param $module
     */
    function __construct($module)
    {
        $this->module = $module;
    }

    /**
     * @return mixed
     */
    public function getModule()
    {
        return $this->module;
    }
}
