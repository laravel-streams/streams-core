<?php namespace Anomaly\Streams\Platform\Addon\Module\Command\Handler;

use Anomaly\Streams\Platform\Addon\Module\Contract\ModuleRepositoryInterface;
use Anomaly\Streams\Platform\Addon\Module\Module;
use Anomaly\Streams\Platform\Addon\Module\ModuleCollection;
use Anomaly\Streams\Platform\Model\EloquentCollection;

/**
 * Class SyncModulesCommandHandler
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Addon\Module\Command
 */
class SyncModulesCommandHandler
{

    /**
     * The module repository.
     *
     * @var ModuleRepositoryInterface
     */
    protected $modules;

    /**
     * The loaded modules.
     *
     * @var ModuleCollection
     */
    protected $collection;

    /**
     * Create a new SyncModulesCommandHandler instance.
     *
     * @param ModuleRepositoryInterface $modules
     */
    public function __construct(ModuleCollection $collection, ModuleRepositoryInterface $modules)
    {
        $this->modules    = $modules;
        $this->collection = $collection;
    }

    /**
     * Sync database modules with physical ones.
     */
    public function handle()
    {
        $modules = $this->modules->all();

        foreach ($this->collection->all() as $module) {
            $this->sync($modules, $module);
        }
    }

    /**
     * Sync a module.
     *
     * @param \Anomaly\Streams\Platform\Model\EloquentCollection $modules
     * @param Module                                             $module
     */
    protected function sync(EloquentCollection $modules, Module $module)
    {
        if (!$modules->findBySlug($module->getSlug())) {
            $this->modules->create($module->getSlug());
        }
    }
}
