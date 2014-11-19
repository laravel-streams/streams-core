<?php namespace Anomaly\Streams\Platform\Addon\Module\Command;

use Anomaly\Streams\Platform\Addon\Module\ModuleModel;

/**
 * Class InsertModuleCommandHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Addon\Module\Command
 */
class InsertModuleCommandHandler
{

    /**
     * The module model.
     *
     * @var \Anomaly\Streams\Platform\Addon\Module\ModuleModel
     */
    protected $module;

    /**
     * Create InsertModuleCommandHandler instance.
     *
     * @param ModuleModel $module
     */
    function __construct(ModuleModel $module)
    {
        $this->module = $module;
    }

    /**
     * Handle the command.
     *
     * @param InsertModuleCommand $command
     * @return mixed
     */
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
 