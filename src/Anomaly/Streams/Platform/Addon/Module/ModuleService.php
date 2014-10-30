<?php namespace Anomaly\Streams\Platform\Addon\Module;

use Anomaly\Streams\Platform\Addon\Module\Command\SyncModulesCommand;
use Anomaly\Streams\Platform\Addon\Module\Event\ModuleWasInstalledEvent;
use Anomaly\Streams\Platform\Addon\Module\Event\ModuleWasUninstalledEvent;
use Anomaly\Streams\Platform\Traits\CommandableTrait;
use Anomaly\Streams\Platform\Traits\DispatchableTrait;
use Anomaly\Streams\Platform\Traits\EventableTrait;
use Illuminate\Foundation\Application;

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
        if ($installer = $module->newInstaller()) {
            foreach (app($installer)->getInstallers() as $installer) {
                $this->app->make($installer)->install();
            }
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

    public function sync()
    {
        $command = new SyncModulesCommand();

        $this->execute($command);
    }
}
