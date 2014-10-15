<?php namespace Streams\Platform\Addon\Module;

use Streams\Platform\Support\Listener;

class ModuleListener extends Listener
{
    protected $module;

    function __construct(ModuleModel $module)
    {
        $this->module = $module;
    }

    public function whenModuleWasInstalled($event)
    {
        $this->module->installed($event->getModule()->getSlug());
    }

    public function whenModuleWasUninstalled($event)
    {
        $this->module->uninstalled($event->getModule()->getSlug());
    }
}
 