<?php

namespace Anomaly\Streams\Platform\Addon\Extension\Event;

use Anomaly\Streams\Platform\Addon\Extension\Extension;

/**
 * Class ExtensionWasEnabled.
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Addon\Extension\Event
 */
class ExtensionWasEnabled
{
    /**
     * The module object.
     *
     * @var Extension
     */
    protected $module;

    /**
     * Create a new ExtensionWasEnabled instance.
     *
     * @param Extension $module
     */
    public function __construct(Extension $module)
    {
        $this->module = $module;
    }

    /**
     * Get the module object.
     *
     * @return Extension
     */
    public function getExtension()
    {
        return $this->module;
    }
}
