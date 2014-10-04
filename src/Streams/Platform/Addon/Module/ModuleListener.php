<?php namespace Streams\Platform\Addon\Module;

use Streams\Platform\Support\EventListener;

class ModuleListener extends EventListener
{
    protected $module;

    function __construct(ModuleModel $module)
    {
        $this->module = $module;
    }

    public function whenModuleInstalled($event)
    {
        $this->module->installed($event->getModule()->getSlug());
    }

    public function whenModuleUninstalled($event)
    {
        $this->module->uninstalled($event->getModule()->getSlug());
    }
}
 