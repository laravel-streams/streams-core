<?php

namespace Anomaly\Streams\Platform\Addon\Extension\Event;

use Anomaly\Streams\Platform\Addon\Extension\Extension;

/**
 * Class ExtensionWasDisabled.
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Addon\Extension\Event
 */
class ExtensionWasDisabled
{
    /**
     * The module object.
     *
     * @var Extension
     */
    protected $module;

    /**
     * Create a new ExtensionWasDisabled instance.
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
