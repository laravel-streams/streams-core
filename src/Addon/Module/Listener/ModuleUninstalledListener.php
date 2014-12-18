<?php namespace Anomaly\Streams\Platform\Addon\Module\Listener;

use Anomaly\Streams\Platform\Addon\Module\Contract\ModuleRepositoryInterface;
use Anomaly\Streams\Platform\Addon\Module\Event\ModuleUninstalledEvent;

/**
 * Class ModuleUninstalledListener
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Addon\Module\Listener
 */
class ModuleUninstalledListener
{

    /**
     * The module repository.
     *
     * @var \Anomaly\Streams\Platform\Addon\Module\Contract\ModuleRepositoryInterface
     */
    protected $modules;

    /**
     * Create a new ModuleUninstalledListener instance.
     *
     * @param ModuleRepositoryInterface $modules
     */
    public function __construct(ModuleRepositoryInterface $modules)
    {
        $this->modules = $modules;
    }

    /**
     * When a module is physically uninstalled we need
     * to update it's database record as uninstalled too.
     *
     * @param ModuleUninstalledEvent $event
     */
    public function handle(ModuleUninstalledEvent $event)
    {
        $module = $event->getModule();

        $this->modules->uninstall($module->getSlug());
    }
}
