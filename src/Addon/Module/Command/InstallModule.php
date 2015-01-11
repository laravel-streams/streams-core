<?php namespace Anomaly\Streams\Platform\Addon\Module\Command;

/**
 * Class InstallModule
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Addon\Module\Command
 */
class InstallModule
{

    /**
     * The module object.
     *
     * @var
     */
    protected $module;

    /**
     * Create a new InstallModule instance.
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
