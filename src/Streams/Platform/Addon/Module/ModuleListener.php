<?php namespace Streams\Platform\Addon\Module;

use Streams\Platform\Support\EventListener;

class ModuleListener extends EventListener
{
    /**
     * The module model.
     *
     * @var ModuleModel
     */
    protected $module;

    /**
     * Create a new ModuleListener instance.
     *
     * @param ModuleModel $module
     */
    function __construct(ModuleModel $module)
    {
        $this->module = $module;
    }

    /**
     * Fire when a module was installed.
     *
     * @param $event
     */
    public function whenModuleWasInstalled($event)
    {
        $this->module->installed($event->getModule()->slug);
    }

    /**
     * Fire when a module was uninstalled.
     *
     * @param $event
     */
    public function whenModuleWasUninstalled($event)
    {
        $this->module->uninstalled($event->getModule()->slug);
    }
}
 