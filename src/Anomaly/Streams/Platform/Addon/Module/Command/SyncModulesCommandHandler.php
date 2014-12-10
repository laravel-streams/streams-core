<?php namespace Anomaly\Streams\Platform\Addon\Module\Command;

use Anomaly\Streams\Platform\Addon\Module\Module;
use Anomaly\Streams\Platform\Addon\Module\ModuleModel;
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

    function __construct(ModuleModel $modules)
    {
        $this->modules = $modules;
    }

    /**
     * Handle the command.
     *
     * @param ModuleModel $modules
     */
    public function handle(SyncModulesCommand $command)
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
     * @param Module             $module
     */
    protected function sync(EloquentCollection $modules, Module $module)
    {
        if (!$match = $modules->findBySlug($module->getSlug())) {

            $slug = $module->getSlug();

            $this->execute('Anomaly\Streams\Platform\Addon\Module\Command\CreateModuleCommand', compact('slug'));
        }
    }
}
 