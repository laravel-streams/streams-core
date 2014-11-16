<?php namespace Anomaly\Streams\Platform\Addon\Module\Command;

use Anomaly\Streams\Platform\Addon\Module\Module;

/**
 * Class InstallModuleCommand
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Addon\Module\Command
 */
class InstallModuleCommand
{

    /**
     * The module object.
     *
     * @var
     */
    protected $module;

    /**
     * Create a new InstallModuleCommand instance.
     *
     * @param Module $module
     */
    function __construct(Module $module)
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
 