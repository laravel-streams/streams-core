<?php namespace Streams\Platform\Addon\Module;

use Streams\Platform\Addon\AddonListener;

class ModuleListener extends AddonListener
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
 