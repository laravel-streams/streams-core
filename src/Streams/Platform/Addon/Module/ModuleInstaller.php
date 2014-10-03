<?php namespace Streams\Platform\Addon\Module;

use Streams\Platform\Addon\AddonInstaller;
use Streams\Platform\Addon\Module\Event\ModuleInstalledEvent;
use Streams\Platform\Addon\Module\Event\ModuleUninstalledEvent;

class ModuleInstaller extends AddonInstaller
{
    /**
     * Run after installing.
     */
    protected function onAfterInstall()
    {
        $this->raise(new ModuleInstalledEvent($this->addon));

        $this->dispatchEventsFor($this);
    }

    /**
     * Run after uninstall.
     */
    protected function onAfterUninstall()
    {
        $this->raise(new ModuleUninstalledEvent($this->addon));

        $this->dispatchEventsFor($this);
    }
}
