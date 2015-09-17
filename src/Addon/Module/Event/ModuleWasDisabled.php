<?php

namespace Anomaly\Streams\Platform\Addon\Module\Event;

use Anomaly\Streams\Platform\Addon\Module\Module;

/**
 * Class ModuleWasDisabled.
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Addon\Module\Event
 */
class ModuleWasDisabled
{
    /**
     * The module object.
     *
     * @var Module
     */
    protected $module;

    /**
     * Create a new ModuleWasDisabled instance.
     *
     * @param Module $module
     */
    public function __construct(Module $module)
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
