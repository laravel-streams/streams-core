<?php namespace Anomaly\Streams\Platform\Addon\Module\Command;

/**
 * Class UninstallModule
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Addon\Module\Command
 */
class UninstallModule
{

    /**
     * The module object.
     *
     * @var
     */
    protected $module;

    /**
     * Create a new UninstallModule command.
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
