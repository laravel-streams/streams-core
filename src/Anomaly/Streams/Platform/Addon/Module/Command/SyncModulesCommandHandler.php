<?php namespace Anomaly\Streams\Platform\Addon\Module\Command;

use Anomaly\Streams\Platform\Addon\Module\Contract\ModuleRepositoryInterface;
use Anomaly\Streams\Platform\Addon\Module\Module;
use Anomaly\Streams\Platform\Model\EloquentCollection;
use Laracasts\Commander\CommanderTrait;

/**
 * Class SyncModulesCommandHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Addon\Module\Command
 */
class SyncModulesCommandHandler
{
    use CommanderTrait;

    protected $modules;

    public function __construct(ModuleRepositoryInterface $modules)
    {
        $this->modules = $modules;
    }

    /**
     * Handle the command.
     */
    public function handle()
    {
        $modules = $this->modules->all();

        foreach (app('streams.modules')->all() as $module) {
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
