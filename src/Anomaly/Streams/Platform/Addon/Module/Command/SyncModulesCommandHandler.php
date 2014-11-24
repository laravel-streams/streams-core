<?php namespace Anomaly\Streams\Platform\Addon\Module\Command;

use Anomaly\Streams\Platform\Addon\Module\Module;
use Anomaly\Streams\Platform\Addon\Module\ModuleModel;
use Anomaly\Streams\Platform\Collection\EloquentCollection;
use Anomaly\Streams\Platform\Traits\CommandableTrait;

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

    use CommandableTrait;

    /**
     * Handle the command.
     *
     * @param ModuleModel $modules
     */
    public function handle(ModuleModel $modules)
    {
        $modules = $modules->all();

        foreach (app('streams.modules')->all() as $module) {

            $this->sync($modules, $module);
        }
    }

    /**
     * Sync a module.
     *
     * @param EloquentCollection $modules
     * @param Module             $module
     */
    protected function sync(EloquentCollection $modules, Module $module)
    {
        if (!$match = $modules->findBySlug($module->getSlug())) {

            $command = new CreateModuleCommand($module->getSlug());

            $this->execute($command);
        }
    }
}
 