<?php namespace Anomaly\Streams\Platform\Addon\Module;

use Anomaly\Streams\Platform\Addon\AddonListener;
use Anomaly\Streams\Platform\Addon\Event\AllRegistered;
use Anomaly\Streams\Platform\Addon\Module\Contract\ModuleRepositoryInterface;
use Anomaly\Streams\Platform\Addon\Module\Event\ModuleInstalled;
use Anomaly\Streams\Platform\Addon\Module\Event\ModuleUninstalled;
use Laracasts\Commander\Events\DispatchableTrait;

/**
 * Class ModuleListener
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Addon\Module
 */
class ModuleListener extends AddonListener
{
    use DispatchableTrait;

    protected $modules;

    public function __construct(ModuleRepositoryInterface $modules)
    {
        $this->modules = $modules;
    }

    public function whenStreamsIsBooting()
    {
        $this->execute('\Anomaly\Streams\Platform\Addon\Module\Command\DetectActiveModuleCommand');
    }

    /**
     * When a module is installed update the database.
     *
     * @param ModuleInstalled $event
     */
    public function whenModuleInstalled(ModuleInstalled $event)
    {
        $module = $event->getModule();

        $this->modules->install($module->getSlug());
    }

    /**
     * When a module is uninstalled update the database.
     *
     * @param ModuleUninstalled $event
     */
    public function whenModuleUninstalled(ModuleUninstalled $event)
    {
        $module = $event->getModule();

        $this->modules->uninstall($module->getSlug());
    }

    /**
     * When all modules are registered - bind the installed / enabled
     * data from the database to the addon classes.
     *
     * @param AllRegistered $event
     */
    public function whenAllRegistered(AllRegistered $event)
    {
        if ($event->getType() == 'module' && app('streams.application')->isLocated()) {
            $this->execute('Anomaly\Streams\Platform\Addon\Module\Command\SetModuleStatesCommand');
        }
    }
}
