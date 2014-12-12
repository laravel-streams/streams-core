<?php namespace Anomaly\Streams\Platform\Addon\Module\Command;

use Anomaly\Streams\Platform\Addon\Module\ModuleService;

class InstallModulesCommandHandler
{
    protected $service;

    function __construct(ModuleService $service)
    {
        $this->service = $service;
    }

    public function handle()
    {
        foreach (app('streams.modules')->all() as $module) {

            $this->service->install($module);

        }
    }
}
