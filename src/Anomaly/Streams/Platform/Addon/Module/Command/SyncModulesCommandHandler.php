<?php namespace Anomaly\Streams\Platform\Addon\Module\Command;

use Anomaly\Streams\Platform\Traits\CommandableTrait;
use Anomaly\Streams\Platform\Addon\Module\ModuleModel;

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

            if (!$match = $modules->findBySlug($module->slug)) {

                $command = new InsertModuleCommand($module->slug);

                $this->execute($command);

            }

        }
    }
}
 