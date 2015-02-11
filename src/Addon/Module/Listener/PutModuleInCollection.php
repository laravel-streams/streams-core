<?php namespace Anomaly\Streams\Platform\Addon\Module\Listener;

use Anomaly\Streams\Platform\Addon\Module\Event\ModuleWasRegistered;
use Anomaly\Streams\Platform\Addon\Module\ModuleCollection;

/**
 * Class PutModuleInCollection
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Addon\Module\Listener
 */
class PutModuleInCollection
{

    /**
     * The module collection.
     *
     * @var ModuleCollection
     */
    protected $modules;

    /**
     * Create a new PutModuleInCollection instance.
     *
     * @param ModuleCollection $modules
     */
    public function __construct(ModuleCollection $modules)
    {
        $this->modules = $modules;
    }

    /**
     * Handle the event.
     *
     * @param ModuleWasRegistered $event
     */
    public function handle(ModuleWasRegistered $event)
    {
        $module = $event->getModule();

        $this->modules->put($module->getNamespace(), $module);
    }
}
