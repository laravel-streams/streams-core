<?php namespace Anomaly\Streams\Platform\Addon\Module\Command;

/**
 * Class UninstallModuleCommand
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Addon\Module\Command
 */
class UninstallModuleCommand
{
    /**
     * The module object.
     *
     * @var
     */
    protected $module;

    /**
     * Create a new UninstallModuleCommand command.
     *
     * @param $module
     */
    public function __construct($module)
    {
        $this->module = $module;
    }

    /**
     * Get the module object.
     *
     * @return mixed
     */
    public function getModule()
    {
        return $this->module;
    }
}
