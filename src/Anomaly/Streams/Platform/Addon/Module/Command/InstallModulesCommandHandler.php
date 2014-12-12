<?php namespace Anomaly\Streams\Platform\Addon\Module\Command;

use Anomaly\Streams\Platform\Addon\Module\ModuleService;

/**
 * Class InstallModulesCommandHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Addon\Module\Command
 */
class InstallModulesCommandHandler
{
    /**
     * @var \Anomaly\Streams\Platform\Addon\Module\ModuleService
     */
    protected $service;

    /**
     * @param ModuleService $service
     */
    function __construct(ModuleService $service)
    {
        $this->service = $service;
    }

    /**
     * Handle the command.
     */
    public function handle()
    {
        foreach (app('streams.modules')->all() as $module) {
            $this->service->install($module);
        }
    }
}
