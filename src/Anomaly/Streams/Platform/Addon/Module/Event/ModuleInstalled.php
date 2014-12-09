<?php namespace Anomaly\Streams\Platform\Addon\Module\Event;

use Anomaly\Streams\Platform\Addon\Module\Module;

/**
 * Class ModuleInstalled
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Addon\Module\Event
 */
class ModuleInstalled
{

    /**
     * The module object.
     *
     * @var \Anomaly\Streams\Platform\Addon\Module\Module
     */
    protected $module;

    /**
     * Create a new ModuleInstalled instance.
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
     * @return Module
     */
    public function getModule()
    {
        return $this->module;
    }
}
