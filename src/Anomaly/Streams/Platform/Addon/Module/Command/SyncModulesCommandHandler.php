<?php namespace Anomaly\Streams\Platform\Addon\Module\Command;

use Anomaly\Streams\Platform\Addon\Module\ModuleModel;
use Anomaly\Streams\Platform\Traits\CommandableTrait;
use Anomaly\Streams\Platform\Addon\Module\ModuleAddon;
use Anomaly\Streams\Platform\Collection\EloquentCollection;

class SyncModulesCommandHandler
{
    use CommandableTrait;

    protected $modules;

    function __construct(ModuleModel $modules)
    {
        $this->modules = $modules;
    }

    public function handle(SyncModulesCommand $command)
    {
        $collection = app('streams.modules');

        $modules = $this->modules->all();

        foreach ($collection as $module) {

            if ($module instanceof ModuleAddon and $modules instanceof EloquentCollection) {

                if (!$match = $modules->findBySlug($module->getSlug())) {

                    $command = new InsertModuleCommand($module->getSlug());

                    $this->execute($command);

                }

            }

        }
    }
}
 