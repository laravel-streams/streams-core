<?php namespace Streams\Platform\Addon\Module;

use Illuminate\Foundation\Application;
use Streams\Platform\Support\Dispatcher;
use Streams\Platform\Traits\EventableTrait;
use Streams\Platform\Traits\CommandableTrait;
use Streams\Platform\Traits\DispatchableTrait;
use Streams\Platform\Addon\Module\Event\ModuleWasInstalledEvent;
use Streams\Platform\Addon\Module\Event\ModuleWasUninstalledEvent;

class ModuleService
{
    use EventableTrait;
    use CommandableTrait;
    use DispatchableTrait;

    protected $app;

    function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function install($module)
    {
        foreach ($module->newInstaller()->getInstallers() as $installer) {
            $this->app->make($installer)->install();
        }

        $this->raise(new ModuleWasInstalledEvent($module));

        $this->dispatchEventsFor($this);

        $module->fire('after_install');

        return true;
    }

    public function uninstall($module)
    {
        foreach ($module->newInstaller()->getInstallers() as $installer) {
            $this->app->make($installer)->uninstall();
        }

        $this->raise(new ModuleWasUninstalledEvent($module));

        $this->dispatchEventsFor($this);

        $module->fire('after_uninstall');

        return true;
    }
}
