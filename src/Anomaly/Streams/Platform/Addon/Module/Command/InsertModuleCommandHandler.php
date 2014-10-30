<?php namespace Anomaly\Streams\Platform\Addon\Module\Command;

use Anomaly\Streams\Platform\Addon\Module\ModuleModel;

class InsertModuleCommandHandler
{

    protected $module;

    function __construct(ModuleModel $module)
    {
        $this->module = $module;
    }

    public function handle(InsertModuleCommand $command)
    {
        return $this->module->insert(
            [
                'slug'         => $command->getSlug(),
                'is_installed' => false,
                'is_enabled'   => false,
            ]
        );
    }
}
 