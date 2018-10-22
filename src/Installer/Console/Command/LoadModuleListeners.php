<?php namespace Anomaly\Streams\Platform\Installer\Console\Command;

use Anomaly\Streams\Platform\Addon\Module\Module;
use Anomaly\Streams\Platform\Addon\Module\ModuleCollection;
use Illuminate\Contracts\Events\Dispatcher;

/**
 * Class LoadModuleInstallers
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class LoadModuleListeners
{
    /**
     * Handle the command.
     *
     * @param ModuleCollection $modules
     * @param Dispatcher       $events
     */
    public function handle(ModuleCollection $modules, Dispatcher $events)
    {
        /* @var Module $module */
        foreach ($modules as $module) {
            if ($module->getNamespace() == 'anomaly.module.installer') {
                continue;
            }

            $provider = $module->getServiceProvider();

            if (!class_exists($provider)) {
                continue;
            }

            $provider = $module->newServiceProvider();

            if (!$listen = $provider->getListeners()) {
                continue;
            }

            foreach ($listen as $event => $listeners) {
                foreach ($listeners as $key => $listener) {
                    if (is_integer($listener)) {
                        $priority = $listener;
                        $listener = $key;
                    } else {
                        $priority = 0;
                    }

                    $events->listen($event, $listener, $priority);
                }
            }
        }
    }
}
