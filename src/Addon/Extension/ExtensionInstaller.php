<?php namespace Anomaly\Streams\Platform\Addon\Extension;

/**
 * Class ExtensionInstaller
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Addon\Extension
 */
class ExtensionInstaller
{

    /**
     * Installers to run.
     *
     * @var array
     */
    protected $installers = [];

    /**
     * Get the installers to run.
     *
     * @return array
     */
    public function getInstallers()
    {
        return $this->installers;
    }
}
