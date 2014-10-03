<?php namespace Streams\Platform\Addon\Module\Event;

class ModuleInstalledEvent
{
    /**
     * The installed module.
     *
     * @var
     */
    protected $module;

    /**
     * Create a new ModuleInstalledEvent instance.
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
