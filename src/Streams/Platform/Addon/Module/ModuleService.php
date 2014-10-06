<?php namespace Streams\Platform\Addon\Module;

use Illuminate\Foundation\Application;
use Streams\Platform\Traits\EventableTrait;
use Streams\Platform\Traits\CommandableTrait;
use Streams\Platform\Support\EventDispatcher;
use Streams\Platform\Addon\Module\Event\ModuleWasInstalledEvent;
use Streams\Platform\Addon\Module\Event\ModuleWasUninstalledEvent;

class ModuleService
{
    use EventableTrait;
    use CommandableTrait;

    protected $app;

    protected $dispatcher;

    function __construct(Application $app, EventDispatcher $dispatcher)
    {
        $this->app = $app;

        $this->dispatcher = $dispatcher;
    }


    public function install(ModuleAddon $module)
    {
        foreach ($module->newInstaller()->getInstallers() as $installer) {
            $this->app->make($installer)->install();
        }

        $this->raise(new ModuleWasInstalledEvent($module));

        $this->dispatcher->dispatch($this->releaseEvents());

        $module->fire('after_install');

        return true;
    }

    public function uninstall(ModuleAddon $module)
    {
        foreach ($module->newInstaller()->getInstallers() as $installer) {
            $this->app->make($installer)->uninstall();
        }

        $this->raise(new ModuleWasUninstalledEvent($module));

        $this->dispatcher->dispatch($this->releaseEvents());

        $module->fire('after_uninstall');

        return true;
    }

    public static function stub()
    {
        throw new \BadMethodCallException("Mismatch between the number of arguments of the factory method and constructor");
    }
}
